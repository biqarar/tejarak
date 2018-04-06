<?php
namespace content_api\v1\team\tools;


trait add
{


	public function add_team($_args = [])
	{
		$edit_mode = false;
		$default_args =
		[
			'method'               => 'post',
			'related'              => null,
			'related_id'           => null,
			'auto_insert_userteam' => true,
		];

		if(!is_array($_args))
		{
			$_args = [];
		}

		$_args = array_merge($default_args, $_args);

		// \dash\notif::title(T_("Operation Faild"));
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => \dash\utility::request(),
			]
		];

		if(!$this->user_id)
		{
			\dash\db\logs::set('api:team:user_id:notfound', null, $log_meta);
			\dash\notif::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		$name = \dash\utility::request('name');
		$name = trim($name);
		if(!$name && $_args['method'] === 'post')
		{
			\dash\db\logs::set('api:team:name:not:set', $this->user_id, $log_meta);
			\dash\notif::error(T_("Team name of team can not be null"), 'name', 'arguments');
			return false;
		}

		if(mb_strlen($name) > 100)
		{
			\dash\db\logs::set('api:team:maxlength:name', $this->user_id, $log_meta);
			\dash\notif::error(T_("Team name must be less than 100 character"), 'name', 'arguments');
			return false;
		}

		$website = \dash\utility::request('website');
		$website = trim($website);
		if($website && mb_strlen($website) > 1000)
		{
			\dash\db\logs::set('api:team:maxlength:website', $this->user_id, $log_meta);
			\dash\notif::error(T_("Team website must be less than 1000 character"), 'website', 'arguments');
			return false;
		}

		$privacy = \dash\utility::request('privacy');
		if(!$privacy && $_args['method'] === 'post')
		{
			$privacy = 'private';
		}

		$privacy = mb_strtolower($privacy);
		if($privacy && !in_array($privacy, ['public', 'private', 'team']))
		{
			\dash\db\logs::set('api:team:privacy:invalid', $this->user_id, $log_meta);
			\dash\notif::error(T_("Invalid privacy field"), 'privacy', 'arguments');
			return false;
		}


		$shortname = \dash\utility::request('short_name');
		$shortname = trim($shortname);

		if(!$shortname && !$name && $_args['method'] === 'post')
		{
			\dash\db\logs::set('api:team:shortname:not:sert', $this->user_id, $log_meta);
			\dash\notif::error(T_("shortname of team can not be null"), 'shortname', 'arguments');
			return false;
		}

		// get slug of name in shortname if the shortname is not set
		if(!$shortname && $name)
		{
			$shortname = \dash\coding::encode((int) $this->user_id + (int) rand(10000,99999) * 10000);
			// $shortname = \dash\utility\filter::slug($name);
		}

		// remove - from shortname
		// if the name is persian and shortname not set
		// we change the shortname as slug of name
		// in the slug we have some '-' in return
		$shortname = str_replace('-', '', $shortname);

		if($shortname && mb_strlen($shortname) < 5)
		{
			\dash\db\logs::set('api:team:minlength:shortname', $this->user_id, $log_meta);
			\dash\notif::error(T_("Team shortname must be larger than 5 character"), 'shortname', 'arguments');
			return false;
		}

		if($shortname && !preg_match("/^[A-Za-z0-9]+$/", $shortname))
		{
			\dash\db\logs::set('api:team:invalid:shortname', $this->user_id, $log_meta);
			\dash\notif::error(T_("Only [A-Za-z0-9] can use in team shortname"), 'shortname', 'arguments');
			return false;
		}

		// check shortname
		if($shortname && mb_strlen($shortname) > 100)
		{
			\dash\db\logs::set('api:team:maxlength:shortname', $this->user_id, $log_meta);
			\dash\notif::error(T_("Team shortname must be less than 500 character"), 'shortname', 'arguments');
			return false;
		}

		$desc = \dash\utility::request('desc');
		if($desc && mb_strlen($desc) > 200)
		{
			\dash\db\logs::set('api:team:maxlength:desc', $this->user_id, $log_meta);
			\dash\notif::error(T_("Team desc must be less than 200 character"), 'desc', 'arguments');
			return false;
		}

		$logo_id = null;
		$logo_url = null;

		$logo = \dash\utility::request('logo');
		if($logo)
		{
			$logo_id = \dash\coding::decode($logo);
			if($logo_id)
			{
				$logo_record = \dash\db\posts::is_attachment($logo_id);
				if(!$logo_record)
				{
					$logo_id = null;
				}
				elseif(isset($logo_record['meta']['url']))
				{
					$logo_url = $logo_record['meta']['url'];
				}
			}
			else
			{
				$logo_id = null;
			}
		}

		$parent = null;

		$parent = \dash\utility::request('parent');
		if($parent)
		{
			$parent = \dash\coding::decode($parent);
		}

		if($parent)
		{
			// check this team and the parent team have one owner
			$check_owner = \lib\db\teams::get(['id' => $parent, 'creator' => $this->user_id, 'limit' => 1]);
			if(!array_key_exists('parent', $check_owner))
			{
				\dash\db\logs::set('api:team:parent:owner:not:match', $this->user_id, $log_meta);
				\dash\notif::error(T_("The parent is not in your team"), 'parent', 'arguments');
				return false;
			}

			// if($check_owner['parent'])
			// {
			// 	\dash\db\logs::set('api:team:parent:parent:full', $this->user_id, $log_meta);
			// 	\dash\notif::error(T_("This parent is a child of another team"), 'parent', 'arguments');
			// 	return false;
			// }
		}


		$lang = \dash\utility::request('language');
		if($lang && (mb_strlen($lang) !== 2 || !\dash\language::check($lang)))
		{
			\dash\db\logs::set('api:team:invalid:lang', $this->user_id, $log_meta);
			\dash\notif::error(T_("Invalid language field"), 'language', 'arguments');
			return false;
		}


		$eventtitle = \dash\utility::request('event_title');
		if($eventtitle && mb_strlen($eventtitle) > 100)
		{
			\dash\db\logs::set('api:team:eventtitle:lenght', $this->user_id, $log_meta);
			\dash\notif::error(T_("You must set the evert title less than 100 character"), 'event_title', 'arguments');
			return false;
		}

		$event_date_start  = \dash\utility::request('event_date_start');
		if($event_date_start && strtotime($event_date_start) === false)
		{
			\dash\db\logs::set('api:team:event_date_start:invalid', $this->user_id, $log_meta);
			\dash\notif::error(T_("Invalid event date"), 'event_date', 'arguments');
			return false;
		}

		if($event_date_start)
		{
			$event_date_start = date("Y-m-d", strtotime($event_date_start));
		}


		$eventdate  = \dash\utility::request('event_date');
		if($eventdate && strtotime($eventdate) === false)
		{
			\dash\db\logs::set('api:team:eventdate:invalid', $this->user_id, $log_meta);
			\dash\notif::error(T_("Invalid event date"), 'event_date', 'arguments');
			return false;
		}

		if($eventdate)
		{
			$eventdate = date("Y-m-d", strtotime($eventdate));
		}

		$cardsize = \dash\utility::request('cardsize');
		if($cardsize && !is_numeric($cardsize))
		{
			\dash\db\logs::set('api:team:cardsize:invalid', $this->user_id, $log_meta);
			\dash\notif::error(T_("Invalid card size"), 'cardsize', 'arguments');
			return false;
		}

		$type = \dash\utility::request('type');
		if($type && !is_string($type))
		{
			\dash\db\logs::set('api:team:add:type:invalid', $this->user_id, $log_meta);
			\dash\notif::error(T_("Invalid team type"), 'type', 'arguments');
			return false;
		}


		$gender = \dash\utility::request('gender');
		if($gender && !in_array($gender, ['male', 'female']))
		{
			\dash\db\logs::set('api:team:add:gender:invalid', $this->user_id, $log_meta);
			\dash\notif::error(T_("Invalid team gender"), 'gender', 'arguments');
			return false;
		}


		$country           = \dash\utility::request('country');
		if($country && mb_strlen($country) > 50)
		{
			\dash\db\logs::set('api:team:add:country:max:lenght', $this->user_id, $log_meta);
			\dash\notif::error(T_("You must set country less than 50 character", 'country', 'arguments'));
			return false;
		}

		$province          = \dash\utility::request('province');
		if($province && mb_strlen($province) > 50)
		{
			\dash\db\logs::set('api:team:add:province:max:lenght', $this->user_id, $log_meta);
			\dash\notif::error(T_("You must set province less than 50 character", 'province', 'arguments'));
			return false;
		}

		$city              = \dash\utility::request('city');
		if($city && mb_strlen($city) > 50)
		{
			\dash\db\logs::set('api:team:add:city:max:lenght', $this->user_id, $log_meta);
			\dash\notif::error(T_("You must set city less than 50 character", 'city', 'arguments'));
			return false;
		}

		$tel               = \dash\utility::request('tel');
		if($tel && mb_strlen($tel) > 50)
		{
			\dash\db\logs::set('api:team:add:tel:max:lenght', $this->user_id, $log_meta);
			\dash\notif::error(T_("You must set tel less than 50 character", 'tel', 'arguments'));
			return false;
		}

		$fax               = \dash\utility::request('fax');
		if($fax && mb_strlen($fax) > 50)
		{
			\dash\db\logs::set('api:team:add:fax:max:lenght', $this->user_id, $log_meta);
			\dash\notif::error(T_("You must set fax less than 50 character", 'fax', 'arguments'));
			return false;
		}

		$zipcode           = \dash\utility::request('zipcode');
		if($zipcode && mb_strlen($zipcode) > 50)
		{
			\dash\db\logs::set('api:team:add:zipcode:max:lenght', $this->user_id, $log_meta);
			\dash\notif::error(T_("You must set zipcode less than 50 character", 'zipcode', 'arguments'));
			return false;
		}

		$awards            = \dash\utility::request('awards');
		if($awards && mb_strlen($awards) > 5000)
		{
			\dash\db\logs::set('api:team:add:awards:max:lenght', $this->user_id, $log_meta);
			\dash\notif::error(T_("You must set awards less than 5000 character", 'awards', 'arguments'));
			return false;
		}

		$desc              = \dash\utility::request('desc');
		if($desc && mb_strlen($desc) > 5000)
		{
			\dash\db\logs::set('api:team:add:desc:max:lenght', $this->user_id, $log_meta);
			\dash\notif::error(T_("You must set desc less than 5000 character", 'desc', 'arguments'));
			return false;
		}

		$about             = \dash\utility::request('about');
		if($about && mb_strlen($about) > 5000)
		{
			\dash\db\logs::set('api:team:add:about:max:lenght', $this->user_id, $log_meta);
			\dash\notif::error(T_("You must set about less than 5000 character", 'about', 'arguments'));
			return false;
		}

		$address             = \dash\utility::request('address');
		if($address && mb_strlen($address) > 5000)
		{
			\dash\db\logs::set('api:team:add:address:max:lenght', $this->user_id, $log_meta);
			\dash\notif::error(T_("You must set address less than 5000 character", 'address', 'arguments'));
			return false;
		}

		$classroom_size = \dash\utility::request('classroom_size');
		if($classroom_size && !is_numeric($classroom_size))
		{
			\dash\db\logs::set('api:team:add:classroom_size:invalid', $this->user_id, $log_meta);
			\dash\notif::error(T_("You must set classroom size as a number", 'classroom_size', 'arguments'));
			return false;
		}

		$status = \dash\utility::request('status');
		if($status && !in_array($status, ['enable', 'disable']))
		{
			\dash\db\logs::set('api:team:add:status:invalid', $this->user_id, $log_meta);
			\dash\notif::error(T_("Invalid status of teams", 'status', 'arguments'));
			return false;
		}

		$multi_classroom = \dash\utility::request('multi_classroom');
		$multi_classroom = $multi_classroom ? true : false;


		$args                    = [];
		$args['creator']         = $this->user_id;
		$args['name']            = $name;
		$args['shortname']       = $shortname;
		$args['website']         = $website;
		$args['desc']            = $desc;
		$args['showavatar']      = \dash\utility::isset_request('show_avatar') ? \dash\utility::request('show_avatar')   ? 1 : 0 : null;
		$args['allowplus']       = \dash\utility::isset_request('allow_plus')  ? \dash\utility::request('allow_plus')    ? 1 : 0 : null;
		$args['allowminus']      = \dash\utility::isset_request('allow_minus') ? \dash\utility::request('allow_minus')   ? 1 : 0 : null;
		$args['remote']          = \dash\utility::isset_request('remote_user') ? \dash\utility::request('remote_user')   ? 1 : 0 : null;
		$args['24h']             = \dash\utility::isset_request('24h')         ? \dash\utility::request('24h')			 ? 1 : 0 : null;

		$args['quick']           = \dash\utility::isset_request('quick_traffic')  ? \dash\utility::request('quick_traffic')    ? 1 : 0 : null;

		$args['allowdescenter']  = \dash\utility::isset_request('allow_desc_enter') ? \dash\utility::request('allow_desc_enter')     ? 1 : 0 : null;
		$args['allowdescexit']   = \dash\utility::isset_request('allow_desc_exit') ? \dash\utility::request('allow_desc_exit')  	 ? 1 : 0 : null;

		$args['lang']            = $lang;
		$args['eventtitle']      = $eventtitle;
		$args['eventdate']       = $event_date_start;
		$args['eventenddate']    = $eventdate;

		$args['manualtimeexit']  = \dash\utility::isset_request('manual_time_exit')   ? \dash\utility::request('manual_time_exit')		? 1 : 0 : null;
		$args['manualtimeenter'] = \dash\utility::isset_request('manual_time_enter')  ? \dash\utility::request('manual_time_enter')		? 1 : 0 : null;
		$args['sendphoto']       = \dash\utility::isset_request('send_photo')         ? \dash\utility::request('send_photo')			? 1 : 0 : null;

		$args['logo']            = $logo_id;
		$args['logourl']         = $logo_url;
		$args['privacy']         = $privacy;
		$args['parent']          = $parent ? $parent : null;
		$args['cardsize']        = $cardsize ? $cardsize : null;
		$args['type']            = $type ? $type : null;

		if($_args['related'])
		{
			$args['related']     = $_args['related'];
		}

		if($_args['related_id'])
		{
			$args['related_id']  = $_args['related_id'];
		}

		$args['gender']          = $gender;

		$args['country']         = $country;
		$args['province']        = $province;
		$args['city']            = $city;
		$args['phone1']          = $tel;
		$args['phone2']          = $fax;
		$args['zipcode']         = $zipcode;
		$args['desc2']           = $address;

		if($status)
		{
			$args['status'] = $status;
		}

		if($type === 'classroom')
		{
			$args['desc3'] = $multi_classroom;
			$args['desc4'] = $classroom_size;
		}
		else
		{
			$args['desc3'] = $awards;
			$args['desc4'] = $about;
		}

		$return = [];

		\dash\temp::set('last_team_added', $shortname);

		if($_args['method'] === 'post')
		{
			// default on add team
			if($args['showavatar'] === null) $args['showavatar'] = 1;
			if($args['allowplus']  === null) $args['allowplus']  = 1;
			if($args['allowminus'] === null) $args['allowminus'] = 1;

			// set default settings in meta
			$args['meta']         = json_encode(['report_settings' => \lib\db\teams::$default_settings_true], JSON_UNESCAPED_UNICODE);

			\dash\db::$debug_error = false;
			$team_id              = \lib\db\teams::insert($args);
			\dash\db::$debug_error = true;

			if(!$team_id)
			{
				$args['shortname'] = $this->shortname_fix($args);
				$team_id = \lib\db\teams::insert($args);
			}

			if(!$team_id)
			{
				\dash\db\logs::set('api:team:no:way:to:insert:team', $this->user_id, $log_meta);
				\dash\notif::error(T_("No way to insert team"), 'db', 'system');
				return false;
			}

			\dash\temp::set('last_team_shortname_added', $args['shortname']);
			\dash\temp::set('last_team_id_added', $team_id);
			\dash\temp::set('last_team_code_added', \dash\coding::encode($team_id));

			if($_args['auto_insert_userteam'])
			{
				$userteam_args                    = [];
				$userteam_args['user_id']         = $this->user_id;
				$userteam_args['team_id']         = $team_id;
				$userteam_args['rule']            = 'admin';
				$userteam_args['displayname']     = T_('You');
				$userteam_args['reportdaily']     = 1;
				$userteam_args['reportenterexit'] = 1;
				\lib\db\userteams::insert($userteam_args);
			}

			$insert_team_plan =
			[
				'team_id' => $team_id,
				'plan'    => 'free',
				'creator' => $this->user_id,
			];
			\lib\db\teamplans::set($insert_team_plan);

			$return['team_id'] = \dash\coding::encode($team_id);

		}
		elseif ($_args['method'] === 'patch')
		{
			$edit_mode = true;
			$id = \dash\utility::request('id');
			$id = \dash\coding::decode($id);
			if(!$id || !is_numeric($id))
			{
				\dash\db\logs::set('api:team:method:put:id:not:set', $this->user_id, $log_meta);
				\dash\notif::error(T_("Id not set"), 'id', 'permission');
				return false;
			}

			$admin_of_team = \lib\db\teams::access_team_id($id, $this->user_id, ['action' => 'edit']);

			if(!$admin_of_team || !isset($admin_of_team['id']) || !isset($admin_of_team['shortname']))
			{
				\dash\db\logs::set('api:team:method:put:permission:denide', $this->user_id, $log_meta);
				\dash\notif::error(T_("Can not access to edit it"), 'team', 'permission');
				return false;
			}

			unset($args['creator']);
			if(!\dash\utility::isset_request('name'))             unset($args['name']);
			if(!\dash\utility::isset_request('short_name'))       unset($args['shortname']);
			if(!\dash\utility::isset_request('website'))          unset($args['website']);
			if(!\dash\utility::isset_request('desc'))             unset($args['desc']);
			if(!\dash\utility::isset_request('show_avatar'))      unset($args['showavatar']);
			if(!\dash\utility::isset_request('allow_plus'))       unset($args['allowplus']);
			if(!\dash\utility::isset_request('allow_minus'))      unset($args['allowminus']);
			if(!\dash\utility::isset_request('remote_user'))      unset($args['remote']);
			if(!\dash\utility::isset_request('24h'))              unset($args['24h']);
			if(!\dash\utility::isset_request('logo'))             unset($args['logo'], $args['logourl']);
			if(!\dash\utility::isset_request('privacy'))          unset($args['privacy']);

			if(!\dash\utility::isset_request('language'))         unset($args['lang']);
			if(!\dash\utility::isset_request('event_title'))      unset($args['eventtitle']);
			if(!\dash\utility::isset_request('event_date_start')) unset($args['eventdate']);
			if(!\dash\utility::isset_request('event_date'))       unset($args['eventenddate']);
			if(!\dash\utility::isset_request('manual_time_exit')) unset($args['manualtimeexit']);
			if(!\dash\utility::isset_request('manual_time_enter'))unset($args['manualtimeenter']);
			if(!\dash\utility::isset_request('send_photo'))       unset($args['sendphoto']);
			if(!\dash\utility::isset_request('cardsize'))         unset($args['cardsize']);
			if(!\dash\utility::isset_request('allow_desc_enter')) unset($args['allowdescenter']);
			if(!\dash\utility::isset_request('allow_desc_exit'))  unset($args['allowdescexit']);
			if(!\dash\utility::isset_request('type'))             unset($args['type']);
			if(!\dash\utility::isset_request('gender'))           unset($args['gender']);
			if(!\dash\utility::isset_request('quick_traffic'))    unset($args['quick']);

			if(!\dash\utility::isset_request('parent'))           unset($args['parent']);

			if(!\dash\utility::isset_request('country'))          unset($args['country']);
			if(!\dash\utility::isset_request('province'))         unset($args['province']);
			if(!\dash\utility::isset_request('city'))             unset($args['city']);
			if(!\dash\utility::isset_request('tel'))              unset($args['phone1']);
			if(!\dash\utility::isset_request('fax'))              unset($args['phone2']);
			if(!\dash\utility::isset_request('zipcode'))          unset($args['zipcode']);
			if(!\dash\utility::isset_request('desc'))             unset($args['desc']);
			if(!\dash\utility::isset_request('address'))          unset($args['desc2']);
			if(!\dash\utility::isset_request('status'))           unset($args['status']);

			if($type  === 'classroom')
			{
				if(!\dash\utility::isset_request('multi_classroom'))  unset($args['desc3']);
				if(!\dash\utility::isset_request('classroom_size'))   unset($args['desc4']);
			}
			else
			{
				if(!\dash\utility::isset_request('awards'))           unset($args['desc3']);
				if(!\dash\utility::isset_request('about'))            unset($args['desc4']);
			}

			if(isset($args['parent']) && intval($args['parent']) === intval($id))
			{
				\dash\db\logs::set('api:team:parent:is:the:team', $this->user_id, $log_meta);
				\dash\notif::error(T_("A team can not be the parent himself"), 'parent', 'arguments');
				return false;
			}

			if(array_key_exists('name', $args) && !$args['name'])
			{
				\dash\db\logs::set('api:team:name:not:set:edit', $this->user_id, $log_meta);
				\dash\notif::error(T_("Team name of team can not be null"), 'name', 'arguments');
				return false;
			}

			if(array_key_exists('shortname', $args) && !$args['shortname'])
			{
				\dash\db\logs::set('api:team:shortname:not:set:edit', $this->user_id, $log_meta);
				\dash\notif::error(T_("shortname of team can not be null"), 'shortname', 'arguments');
				return false;
			}

			if(array_key_exists('privacy', $args) && !in_array($args['privacy'], ['public', 'private', 'team']))
			{
				\dash\db\logs::set('api:team:privacy:invalid:edit', $this->user_id, $log_meta);
				\dash\notif::error(T_("Invalid privacy field"), 'privacy', 'arguments');
				return false;
			}

			if(!empty($args))
			{
				$update = \lib\db\teams::update($args, $admin_of_team['id']);

				if(isset($args['shortname']))
				{
					if(!$update)
					{
						$args['shortname'] = $this->shortname_fix($args);
						$update = \lib\db\teams::update($args, $admin_of_team['id']);
					}
					// user change shortname
					if($admin_of_team['shortname'] != $args['shortname'])
					{
						\dash\db\logs::set('api:team:change:shortname', $this->user_id, $log_meta);
						// must be update all gateway username user old shortname at the first of herusername
						// to new shortname
						$update_gateway =
						[
							'old_shortname' => $admin_of_team['shortname'],
							'new_shortname' => $args['shortname'],
							'team_id'       => $admin_of_team['id'],
						];
						\lib\db\userteams::gateway_username_fix($update_gateway);
					}
				}
			}
		}
		else
		{
			\dash\db\logs::set('api:team:method:invalid', $this->user_id, $log_meta);
			\dash\notif::error(T_("Invalid method of api"), 'method', 'permission');
			return false;
		}


		if(\lib\engine\process::status())
		{
			// \dash\notif::title(T_("Operation Complete"));
			if($edit_mode)
			{
				\dash\notif::ok(T_("Team successfuly edited"));
			}
			else
			{
				\dash\notif::ok(T_("Team successfuly added"));
			}
		}

		return $return;
	}


	/**
	 * fix duplicate shortname
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function shortname_fix($_args)
	{
		if(!isset($_args['shortname']))
		{
			$_args['shortname'] = (string) $this->user_id. (string) rand(1000,5000);
		}

		$new_short_name    = null;
		$similar_shortname = \lib\db\teams::get_similar_shortname($_args['shortname']);
		$count             = count($similar_shortname);
		$i                 = 1;
		$new_short_name    = (string) $_args['shortname']. (string) ((int) $count +  (int) $i);
		while (in_array($new_short_name, $similar_shortname))
		{
			$i++;
			$new_short_name    = (string) $_args['shortname']. (string) ((int) $count +  (int) $i);
		}

		\dash\temp::set('last_team_added', $new_short_name);
		return $new_short_name;
	}
}
?>