<?php
namespace content_api\v1\notification\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;
trait add
{

	public function add_notification($_args = [])
	{
		$edit_mode = false;
		$default_args =
		[
			'method' => 'post'
		];

		if(!is_array($_args))
		{
			$_args = [];
		}

		$_args = array_merge($default_args, $_args);

		debug::title(T_("Operation Faild"));
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => utility::request(),
			]
		];

		if(!$this->user_id)
		{
			logs::set('api:notification:user_id:notfound', null, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		$name = utility::request('name');
		$name = trim($name);
		if(!$name)
		{
			logs::set('api:notification:name:not:set', $this->user_id, $log_meta);
			debug::error(T_("notification name of notification can not be null"), 'name', 'arguments');
			return false;
		}

		if(mb_strlen($name) > 100)
		{
			logs::set('api:notification:maxlength:name', $this->user_id, $log_meta);
			debug::error(T_("notification name must be less than 100 character"), 'name', 'arguments');
			return false;
		}

		$website = utility::request('website');
		$website = trim($website);
		if($website && mb_strlen($website) > 1000)
		{
			logs::set('api:notification:maxlength:website', $this->user_id, $log_meta);
			debug::error(T_("notification website must be less than 1000 character"), 'website', 'arguments');
			return false;
		}

		$privacy = utility::request('privacy');
		if(!$privacy)
		{
			$privacy = 'private';
		}

		if(!in_array(mb_strtolower($privacy), ['public', 'private', 'notification']))
		{
			logs::set('api:notification:privacy:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid privacy field"), 'privacy', 'arguments');
			return false;
		}
		$privacy = mb_strtolower($privacy);

		$shortname = utility::request('short_name');
		$shortname = trim($shortname);

		if(!$shortname && !$name)
		{
			logs::set('api:notification:shortname:not:sert', $this->user_id, $log_meta);
			debug::error(T_("shortname of notification can not be null"), 'shortname', 'arguments');
			return false;
		}

		// get slug of name in shortname if the shortname is not set
		if(!$shortname && $name)
		{
			$shortname = \lib\utility\shortURL::encode((int) $this->user_id + (int) rand(10000,99999) * 10000);
			// $shortname = \lib\utility\filter::slug($name);
		}

		// remove - from shortname
		// if the name is persian and shortname not set
		// we change the shortname as slug of name
		// in the slug we have some '-' in return
		$shortname = str_replace('-', '', $shortname);

		if(mb_strlen($shortname) < 5)
		{
			logs::set('api:notification:minlength:shortname', $this->user_id, $log_meta);
			debug::error(T_("notification shortname must be larger than 5 character"), 'shortname', 'arguments');
			return false;
		}

		if(!preg_match("/^[A-Za-z0-9]+$/", $shortname))
		{
			logs::set('api:notification:invalid:shortname', $this->user_id, $log_meta);
			debug::error(T_("Only [A-Za-z0-9] can use in notification shortname"), 'shortname', 'arguments');
			return false;
		}

		// check shortname
		if(mb_strlen($shortname) > 100)
		{
			logs::set('api:notification:maxlength:shortname', $this->user_id, $log_meta);
			debug::error(T_("notification shortname must be less than 500 character"), 'shortname', 'arguments');
			return false;
		}

		$desc = utility::request('desc');
		if($desc && mb_strlen($desc) > 200)
		{
			logs::set('api:notification:maxlength:desc', $this->user_id, $log_meta);
			debug::error(T_("notification desc must be less than 200 character"), 'desc', 'arguments');
			return false;
		}

		$logo_id = null;
		$logo_url = null;

		$logo = utility::request('logo');
		if($logo)
		{
			$logo_id = \lib\utility\shortURL::decode($logo);
			if($logo_id)
			{
				$logo_record = \lib\db\posts::is_attachment($logo_id);
				if(!$logo_record)
				{
					$logo_id = null;
				}
				elseif(isset($logo_record['post_meta']['url']))
				{
					$logo_url = $logo_record['post_meta']['url'];
				}
			}
			else
			{
				$logo_id = null;
			}
		}

		$parent = null;

		// $parent = utility::request('parent');
		// if($parent)
		// {
		// 	$parent = \lib\utility\shortURL::decode($parent);
		// }

		// if($parent)
		// {
		// 	// check this notification and the parent notification have one owner
		// 	$check_owner = \lib\db\notifications::get(['id' => $parent, 'creator' => $this->user_id, 'limit' => 1]);
		// 	if(!array_key_exists('parent', $check_owner))
		// 	{
		// 		logs::set('api:notification:parent:owner:not:match', $this->user_id, $log_meta);
		// 		debug::error(T_("The parent is not in your notification"), 'parent', 'arguments');
		// 		return false;
		// 	}

		// 	if($check_owner['parent'])
		// 	{
		// 		logs::set('api:notification:parent:parent:full', $this->user_id, $log_meta);
		// 		debug::error(T_("This parent is a child of another notification"), 'parent', 'arguments');
		// 		return false;
		// 	}
		// }


		$args               = [];
		$args['creator']    = $this->user_id;
		$args['name']       = $name;
		$args['shortname']  = $shortname;
		$args['website']    = $website;
		$args['desc']       = $desc;
		$args['showavatar'] = utility::isset_request('show_avatar') ? utility::request('show_avatar')   ? 1 : 0 : null;
		$args['allowplus']  = utility::isset_request('allow_plus')  ? utility::request('allow_plus')    ? 1 : 0 : null;
		$args['allowminus'] = utility::isset_request('allow_minus') ? utility::request('allow_minus')   ? 1 : 0 : null;
		$args['remote']     = utility::isset_request('remote_user') ? utility::request('remote_user') 	? 1 : 0 : null;
		$args['24h']        = utility::isset_request('24h')         ? utility::request('24h')			? 1 : 0 : null;
		$args['logo']       = $logo_id;
		$args['logourl']    = $logo_url;
		$args['privacy']    = $privacy;
		$args['parent']     = $parent ? $parent : null;

		\lib\storage::set_last_notification_added($shortname);

		if($_args['method'] === 'post')
		{
			// set default settings in meta
			$args['meta']         = json_encode(['report_settings' => \lib\db\notifications::$default_settings_true], JSON_UNESCAPED_UNICODE);

			\lib\db::$debug_error = false;
			$notification_id              = \lib\db\notifications::insert($args);
			\lib\db::$debug_error = true;

			if(!$notification_id)
			{
				$args['shortname'] = $this->shortname_fix($args);
				$notification_id = \lib\db\notifications::insert($args);
			}

			if(!$notification_id)
			{
				logs::set('api:notification:no:way:to:insert:notification', $this->user_id, $log_meta);
				debug::error(T_("No way to insert notification"), 'db', 'system');
				return false;
			}

			\lib\storage::set_last_notification_code_added(\lib\utility\shortURL::encode($notification_id));

			$usernotification_args                = [];
			$usernotification_args['user_id']     = $this->user_id;
			$usernotification_args['notification_id']     = $notification_id;
			$usernotification_args['rule']        = 'admin';
			$usernotification_args['displayname'] = 'You';
			\lib\db\usernotifications::insert($usernotification_args);

			$insert_notification_plan =
			[
				'notification_id' => $notification_id,
				'plan'    => 'free',
				'creator' => $this->login('id'),
			];
			\lib\db\notificationplans::set($insert_notification_plan);

		}
		elseif ($_args['method'] === 'patch')
		{
			$edit_mode = true;
			$id = utility::request('id');
			$id = \lib\utility\shortURL::decode($id);
			if(!$id || !is_numeric($id))
			{
				logs::set('api:notification:method:put:id:not:set', $this->user_id, $log_meta);
				debug::error(T_("Id not set"), 'id', 'permission');
				return false;
			}

			$admin_of_notification = \lib\db\notifications::access_notification_id($id, $this->user_id, ['action' => 'edit']);

			if(!$admin_of_notification || !isset($admin_of_notification['id']) || !isset($admin_of_notification['shortname']))
			{
				logs::set('api:notification:method:put:permission:denide', $this->user_id, $log_meta);
				debug::error(T_("Can not access to edit it"), 'notification', 'permission');
				return false;
			}

			unset($args['creator']);
			if(!utility::isset_request('name')) 			unset($args['name']);
			if(!utility::isset_request('short_name')) 		unset($args['shortname']);
			if(!utility::isset_request('website')) 			unset($args['website']);
			if(!utility::isset_request('desc')) 			unset($args['desc']);
			if(!utility::isset_request('show_avatar')) 		unset($args['showavatar']);
			if(!utility::isset_request('allow_plus')) 		unset($args['allowplus']);
			if(!utility::isset_request('allow_minus')) 		unset($args['allowminus']);
			if(!utility::isset_request('remote_user')) 		unset($args['remote']);
			if(!utility::isset_request('24h')) 				unset($args['24h']);
			if(!utility::isset_request('logo')) 			unset($args['logo'], $args['logourl']);
			if(!utility::isset_request('privacy')) 			unset($args['privacy']);
			// if(!utility::isset_request('parent')) 			unset($args['parent']);

			// if(isset($args['parent']) && intval($args['parent']) === intval($id))
			// {
			// 	logs::set('api:notification:parent:is:the:notification', $this->user_id, $log_meta);
			// 	debug::error(T_("A notification can not be the parent himself"), 'parent', 'arguments');
			// 	return false;
			// }

			if(!empty($args))
			{
				\lib\db::$debug_error = false;
				$update = \lib\db\notifications::update($args, $admin_of_notification['id']);
				\lib\db::$debug_error = true;
				if(!$update)
				{
					$args['shortname'] = $this->shortname_fix($args);
					$update = \lib\db\notifications::update($args, $admin_of_notification['id']);
				}
				// user change shortname
				if($admin_of_notification['shortname'] != $args['shortname'])
				{
					logs::set('api:notification:change:shortname', $this->user_id, $log_meta);
					// must be update all gateway username user old shortname at the first of herusername
					// to new shortname
					$update_gateway =
					[
						'old_shortname' => $admin_of_notification['shortname'],
						'new_shortname' => $args['shortname'],
						'notification_id'       => $admin_of_notification['id'],
					];
					\lib\db\usernotifications::gateway_username_fix($update_gateway);
				}
			}
		}
		else
		{
			logs::set('api:notification:method:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid method of api"), 'method', 'permission');
			return false;
		}

		if(debug::$status)
		{
			debug::title(T_("Operation Complete"));
			if($edit_mode)
			{
				debug::true(T_("notification successfuly edited"));
			}
			else
			{
				debug::true(T_("notification successfuly added"));
			}
		}
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
		$similar_shortname = \lib\db\notifications::get_similar_shortname($_args['shortname']);
		$count             = count($similar_shortname);
		$i                 = 1;
		$new_short_name    = (string) $_args['shortname']. (string) ((int) $count +  (int) $i);
		while (in_array($new_short_name, $similar_shortname))
		{
			$i++;
			$new_short_name    = (string) $_args['shortname']. (string) ((int) $count +  (int) $i);
		}

		\lib\storage::set_last_notification_added($new_short_name);
		return $new_short_name;
	}
}
?>