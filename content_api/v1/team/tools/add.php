<?php
namespace content_api\v1\team\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;
trait add
{


	public function add_team($_args = [])
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
			logs::set('api:team:user_id:notfound', null, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		$name = utility::request('name');
		$name = trim($name);
		if(!$name)
		{
			logs::set('api:team:name:not:set', $this->user_id, $log_meta);
			debug::error(T_("Team name of team can not be null"), 'name', 'arguments');
			return false;
		}

		if(mb_strlen($name) > 100)
		{
			logs::set('api:team:maxlength:name', $this->user_id, $log_meta);
			debug::error(T_("Team name must be less than 100 character"), 'name', 'arguments');
			return false;
		}

		$website = utility::request('website');
		$website = trim($website);
		if($website && mb_strlen($website) > 1000)
		{
			logs::set('api:team:maxlength:website', $this->user_id, $log_meta);
			debug::error(T_("Team website must be less than 1000 character"), 'website', 'arguments');
			return false;
		}

		$privacy = utility::request('privacy');
		if(!$privacy)
		{
			$privacy = 'public';
		}

		if(!in_array(mb_strtolower($privacy), ['public', 'private']))
		{
			logs::set('api:team:privacy:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid privacy field"), 'privacy', 'arguments');
			return false;
		}
		$privacy = mb_strtolower($privacy);

		$shortname = utility::request('short_name');
		$shortname = trim($shortname);

		if(!$shortname && !$name)
		{
			logs::set('api:team:shortname:not:sert', $this->user_id, $log_meta);
			debug::error(T_("shortname of team can not be null"), 'shortname', 'arguments');
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
			logs::set('api:team:minlength:shortname', $this->user_id, $log_meta);
			debug::error(T_("Team shortname must be larger than 5 character"), 'shortname', 'arguments');
			return false;
		}

		if(!preg_match("/^[A-Za-z0-9]+$/", $shortname))
		{
			logs::set('api:team:invalid:shortname', $this->user_id, $log_meta);
			debug::error(T_("Only [A-Za-z0-9] can use in team shortname"), 'shortname', 'arguments');
			return false;
		}

		// check shortname
		if(mb_strlen($shortname) > 100)
		{
			logs::set('api:team:maxlength:shortname', $this->user_id, $log_meta);
			debug::error(T_("Team shortname must be less than 500 character"), 'shortname', 'arguments');
			return false;
		}

		$desc = utility::request('desc');
		if($desc && mb_strlen($desc) > 200)
		{
			logs::set('api:team:maxlength:desc', $this->user_id, $log_meta);
			debug::error(T_("Team desc must be less than 200 character"), 'desc', 'arguments');
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

		\lib\storage::set_last_team_added($shortname);

		if($_args['method'] === 'post')
		{
			\lib\db::$debug_error = false;
			$team_id = \lib\db\teams::insert($args);
			\lib\db::$debug_error = true;

			if(!$team_id)
			{
				$args['shortname'] = $this->shortname_fix($args);
				$team_id = \lib\db\teams::insert($args);
			}

			if(!$team_id)
			{
				logs::set('api:team:no:way:to:insert:team', $this->user_id, $log_meta);
				debug::error(T_("No way to insert team"), 'db', 'system');
				return false;
			}

			\lib\storage::set_last_team_code_added(\lib\utility\shortURL::encode($team_id));

			$userteam_args                = [];
			$userteam_args['user_id']     = $this->user_id;
			$userteam_args['team_id']     = $team_id;
			$userteam_args['rule']        = 'admin';
			$userteam_args['displayname'] = 'You';
			\lib\db\userteams::insert($userteam_args);

			$insert_team_plan =
			[
				'team_id' => $team_id,
				'plan'    => 'free',
				'creator' => $this->login('id'),
			];
			\lib\db\teamplans::set($insert_team_plan);

		}
		elseif ($_args['method'] === 'patch')
		{
			$edit_mode = true;
			$id = utility::request('id');
			$id = \lib\utility\shortURL::decode($id);
			if(!$id || !is_numeric($id))
			{
				logs::set('api:team:method:put:id:not:set', $this->user_id, $log_meta);
				debug::error(T_("Id not set"), 'id', 'permission');
				return false;
			}

			$admin_of_team = \lib\db\teams::access_team_id($id, $this->user_id, ['action' => 'edit']);

			if(!$admin_of_team || !isset($admin_of_team['id']))
			{
				logs::set('api:team:method:put:permission:denide', $this->user_id, $log_meta);
				debug::error(T_("Can not access to edit it"), 'team', 'permission');
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

			if(!empty($args))
			{
				\lib\db::$debug_error = false;
				$update = \lib\db\teams::update($args, $admin_of_team['id']);
				\lib\db::$debug_error = true;
				if(!$update)
				{
					$args['shortname'] = $this->shortname_fix($args);
					$update = \lib\db\teams::update($args, $admin_of_team['id']);
				}
			}
		}
		else
		{
			logs::set('api:team:method:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid method of api"), 'method', 'permission');
			return false;
		}

		if(debug::$status)
		{
			debug::title(T_("Operation Complete"));
			if($edit_mode)
			{
				debug::true(T_("Team successfuly edited"));
			}
			else
			{
				debug::true(T_("Team successfuly added"));
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
		$similar_shortname = \lib\db\teams::get_similar_shortname($_args['shortname']);
		$count             = count($similar_shortname);
		$i                 = 1;
		$new_short_name    = (string) $_args['shortname']. (string) ((int) $count +  (int) $i);
		while (in_array($new_short_name, $similar_shortname))
		{
			$i++;
			$new_short_name    = (string) $_args['shortname']. (string) ((int) $count +  (int) $i);
		}

		\lib\storage::set_last_team_added($new_short_name);
		return $new_short_name;
	}
}
?>