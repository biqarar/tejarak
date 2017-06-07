<?php
namespace content_api\v1\member\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait add
{


	/**
	 * Adds a member.
	 *
	 * @param      array    $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function add_member($_args = [])
	{
		// default args
		$default_args =
		[
			'method' => 'post'
		];

		if(!is_array($_args))
		{
			$_args = [];
		}
		// merge default args and args
		$_args = array_merge($default_args, $_args);

		// set default title of debug
		debug::title(T_("Operation Faild"));

		// delete member mode
		$delete_mode = false;

		// set the log meta
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => utility::request(),
			]
		];

		// update user details
		$update_user = [];

		// check user id is exist
		if(!$this->user_id)
		{
			logs::set('api:member:user_id:notfound', null, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		// get team and check it
		$team = utility::request('team');
		if(!$team)
		{
			logs::set('api:member:team:notfound', null, $log_meta);
			debug::error(T_("Team not found"), 'user', 'permission');
			return false;
		}
		// load team data
		$team_detail = \lib\db\teams::get_brand($team);
		// check the team exist
		if(isset($team_detail['id']))
		{
			$team_id = $team_detail['id'];
		}
		else
		{
			logs::set('api:member:team:notfound:invalid', null, $log_meta);
			debug::error(T_("Team not found"), 'user', 'permission');
			return false;
		}

		// check team boos is the user id
		if(isset($team_detail['boss']) && intval($team_detail['boss']) === intval($this->user_id))
		{
			// no problem to add member fo this
		}
		else
		{
			logs::set('api:member:team:permission', null, $log_meta);
			debug::error(T_("Permission denide to add member of this team"), 'user', 'permission');
			return false;
		}
		// get mobile of user
		$mobile = utility::request("mobile");
		$mobile = \lib\utility\filter::mobile($mobile);
		if(!$mobile)
		{
			logs::set('api:member:mobile:not:set', $this->user_id, $log_meta);
			debug::error(T_("Invalid mobile number"), 'mobile', 'arguments');
			return false;
		}
		// get name
		$name = utility::request("name");
		if($name && mb_strlen($name) > 50)
		{
			logs::set('api:member:name:max:length', $this->user_id, $log_meta);
			debug::error(T_("You can set the name less than 50 character"), 'name', 'arguments');
			return false;
		}
		// update user name
		if($name)
		{
			$update_user['user_name'] = $name;
		}

		// get family
		$family = utility::request("family");
		if($family && mb_strlen($family) > 50)
		{
			logs::set('api:member:family:max:length', $this->user_id, $log_meta);
			debug::error(T_("You can set the family less than 50 character"), 'family', 'arguments');
			return false;
		}
		// update user family
		if($family)
		{
			$update_user['user_family'] = $family;
		}

		$check_user_exist = \lib\db\users::get_by_mobile($mobile);

		$user_id = null;

		if(isset($check_user_exist['id']))
		{
			$user_id = $check_user_exist['id'];
		}
		else
		{
			$signup =
			[
				'mobile'      => $mobile,
				'password'    => null,
				'displayname' => $name. ' '. $family,
			];

			$user_id = \lib\db\users::signup($signup);
		}

		if(!$user_id)
		{
			logs::set('api:member:user_id:not:found:and:cannot:signup', $this->user_id, $log_meta);
			debug::error(T_("User id not found"), 'user', 'system');
			return false;
		}

		// get postion
		$postion     = utility::request('postion');
		if($postion && mb_strlen($postion) > 100)
		{
			logs::set('api:member:postion:max:length', $this->user_id, $log_meta);
			debug::error(T_("You can set the postion less than 100 character"), 'postion', 'arguments');
			return false;
		}

		// update user postion
		if($postion)
		{
			$update_user['user_postion'] = $postion;
		}

		$code       = utility::request('code');
		if($code && (mb_strlen($code) > 9 || !ctype_digit($code)))
		{
			logs::set('api:member:code:max:length', $this->user_id, $log_meta);
			debug::error(T_("You can set the code less than 9 character and must ba integer"), 'code', 'arguments');
			return false;
		}

		// $telegram_id = utility::request('telegram_id');

		$full_time   = utility::request('full_time')	? 1 : 0;
		$remote      = utility::request('remote') 		? 1 : 0;
		$is_default  = utility::request('is_default') 	? 1 : 0;

		// get date enter
		$date_enter  = utility::request('date_enter');
		if($date_enter && \DateTime::createFromFormat('Y-m-d', $date_enter) === false)
		{
			logs::set('api:member:date_enter:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid date of date enter"), 'date_enter', 'arguments');
			return false;
		}

		// get date exit
		$date_exit   = utility::request('date_exit');
		if($date_exit && \DateTime::createFromFormat('Y-m-d', $date_exit) === false)
		{
			logs::set('api:member:date_exit:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid date of date exit"), 'date_exit', 'arguments');
			return false;
		}

		// default the user add to team only
		// if the branch is set the user add to team and branch
		$add_to_branch = false;

		// get date exit
		$branch   = utility::request('branch');
		if($branch)
		{
			if($load_branch = \lib\db\branchs::get_by_brand($team, $branch))
			{
				if(isset($load_branch['id']))
				{
					$branch_id = $load_branch['id'];
					$add_to_branch = true;
				}
			}
		}
		// get file code
		$file_code  = utility::request('file');
		$file_id = null;
		if($file_code)
		{
			// decode file code
			$file = \lib\utility\shortURL::decode($file_code);
			if($file && is_int($file))
			{
				// check the file is draft or publish and is attachment
				$check_file_permission =
				"
					SELECT
						posts.id AS `id`
					FROM
						posts
					WHERE
						posts.id        = $file AND
						posts.post_type = 'attachment' AND
						posts.post_status IN ('draft', 'publish')
					LIMIT 1
				";
				// if file permission is ok set the file_id
				if(\lib\db::get($check_file_permission, 'id', true))
				{
					$update_user['user_file_id'] = $file;
				}
			}
		}

		// save update user if not empty
		if(!empty($update_user))
		{
			\lib\db\users::update($update_user, $user_id);
		}

		// ready to insert userteam or userbranch record
		$args               = [];
		$args['team_id']    = $team_id;
		$args['user_id']    = $user_id;
		$args['postion']    = $postion;
		$args['code']       = $code;
		$args['full_time']  = $full_time;
		$args['remote']     = $remote;
		$args['is_default'] = $is_default;
		$args['date_enter'] = $date_enter;
		$args['date_exit']  = $date_exit;

		if($_args['method'] === 'post')
		{
			\lib\db\userteams::insert($args);
			if($add_to_branch)
			{
				$args['branch_id'] = $branch_id;
				\lib\db\userbranchs::insert($args);
			}
		}
		elseif($_args['method'] === 'patch')
		{
			$id = utility::request('id');
			unset($args['team_id']);
			unset($args['user_id']);
			if($add_to_branch)
			{
				\lib\db\userbranchs::update($args, $id);
			}
			else
			{
				\lib\db\userteams::update($args, $id);
			}
		}
		elseif ($_args['method'] === 'delete')
		{
			if($add_to_branch)
			{
				$args['branch_id'] = $branch_id;
			}
			\lib\db\members::remove($args);
		}

		if(debug::$status)
		{
			debug::title(T_("Operation Complete"));

			if($_args['method'] === 'post')
			{
				debug::true(T_("member successfully added"));
			}
			elseif($_args['method'] === 'patch')
			{
				debug::true(T_("member successfully updated"));
			}
			else
			{
				debug::true(T_("member successfully removed"));
			}
		}

	}
}
?>