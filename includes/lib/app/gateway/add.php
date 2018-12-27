<?php
namespace lib\app\gateway;


trait add
{


	/**
	 * Adds a gateway.
	 *
	 * @param      array    $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function add_gateway($_args = [])
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

		// set default title of \lib\notif
		// \dash\notif::title(T_("Operation Faild"));

		// delete gateway mode
		$delete_mode = false;

		// set the log meta
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => \dash\app::request(),
			]
		];

		// check user id is exist
		if(!\dash\user::id())
		{
			\dash\db\logs::set('api:gateway:user_id:notfound', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		// get team and check it
		$team = \dash\app::request('team');
		$team = \dash\coding::decode($team);
		if(!$team)
		{
			\dash\db\logs::set('api:gateway:team:not:set', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Team not set"), 'user', 'permission');
			return false;
		}
		// load team data
		$team_detail = \lib\db\teams::access_team_id($team, \dash\user::id(), ['action' => 'add_gateway']);
		// check the team exist
		if(isset($team_detail['id']))
		{
			$team_id = $team_detail['id'];
		}
		else
		{
			\dash\db\logs::set('api:gateway:team:notfound:invalid', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Team not found"), 'user', 'permission');
			return false;
		}

		// get firstname
		$name = \dash\app::request("name");
		$name = trim($name);
		if($name && mb_strlen($name) > 50)
		{
			\dash\db\logs::set('api:gateway:name:max:length', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("You can set the name less than 50 character"), 'name', 'arguments');
			return false;
		}

		if(!$name)
		{
			\dash\db\logs::set('api:gateway:name:not:set', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("The gateway name can not be null"), 'name', 'arguments');
			return false;
		}

		$displayname = $name;

		if(!isset($team_detail['shortname']))
		{
			\dash\db\logs::set('api:gateway:shortname:not:found', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Shortname of your team is not definde"), 'shortname', 'system');
			return false;
		}

		$password = \dash\app::request('password');
		if(!$password && $_args['method'] === 'post')
		{
			\dash\db\logs::set('api:gateway:password:not:set', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("You can set the password as null"), 'password', 'arguments');
			return false;
		}
		if(mb_strlen($password) > 50)
		{
			\dash\db\logs::set('api:gateway:password:max:length', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("You can set the password less than 50 character"), 'password', 'arguments');
			return false;
		}

		if($password)
		{
			$password = \dash\utility::hasher($password);
		}

		$username = \dash\app::request('username');
		if(!$username)
		{
			\dash\db\logs::set('api:gateway:username:not:set', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("You can set the username as null"), 'username', 'arguments');
			return false;
		}
		if(mb_strlen($username) > 10)
		{
			\dash\db\logs::set('api:gateway:username:max:length', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("You can set the username less than 50 character"), 'username', 'arguments');
			return false;
		}
		if(!preg_match("/^[a-zA-Z0-9]+$/", $username))
		{
			\dash\db\logs::set('api:gateway:username:reqular:not:match', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Only [a-z,A-Z,0-9] character can use in username"), 'username', 'arguments');
			return false;
		}

		$username = $team_detail['shortname']. '-'. $username;

		$user_id  = null;

		if($_args['method'] === 'post')
		{
			$check_duplicate_username = \dash\db\users::get_by_username($username);
			if($check_duplicate_username)
			{
				\dash\db\logs::set('api:gateway:username:duplicate', \dash\user::id(), $log_meta);
				\dash\notif::error(T_("Duplicate username! Please select another username"), 'username', 'arguments');
				return false;
			}

			$insert_users =
			[
				'parent'      => \dash\user::id(),
				'datecreated' => date("Y-m-d H:i:s"),
				'displayname' => $displayname,
				'username'    => $username,
				'password'    => $password,
			];
			$user_id = \dash\db\users::signup($insert_users);
		}
		elseif($_args['method'] === 'patch')
		{
			$id = \dash\app::request('id');
			$user_id = \dash\coding::decode($id);
			if($user_id)
			{
				$check_user_is_gateway = \lib\db\userteams::get(['user_id' => $user_id, 'rule' => 'gateway', 'limit' => 1]);
				if(!$check_user_is_gateway)
				{
					\dash\db\logs::set('api:gateway:user_id:is:not:gateway:user', \dash\user::id(), $log_meta);
					\dash\notif::error(T_("User id is not a gateway user!"), 'user', 'permission');
					return false;
				}

				$check_duplicate_username = \dash\db\users::get_by_username($username);
				if($check_duplicate_username)
				{
					if(isset($check_duplicate_username['id']) && intval($check_duplicate_username['id']) === intval($user_id))
					{

					}
					else
					{
						\dash\db\logs::set('api:gateway:username:duplicate', \dash\user::id(), $log_meta);
						\dash\notif::error(T_("Duplicate username! Please select another username"), 'username', 'arguments');
						return false;
					}
				}
			}
		}


		if(!$user_id)
		{
			\dash\db\logs::set('api:gateway:user_id:not:found:and:cannot:signup', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("User id not found"), 'user', 'system');
			return false;
		}

		// get status
		$status = \dash\app::request('status');

		if($status)
		{
			if(!in_array($status, ['active', 'deactive']))
			{
				\dash\db\logs::set('api:gateway:status:invalid', \dash\user::id(), $log_meta);
				\dash\notif::error(T_("Invalid parameter status"), 'status', 'arguments');
				return false;
			}
		}
		else
		{
			$status = 'active';
		}

		// ready to insert userteam or userbranch record
		$args                  = [];
		$args['team_id']       = $team_id;
		$args['user_id']       = $user_id;
		$args['displayname']   = $displayname;
		$args['status']        = $status;
		$args['rule']          = 'gateway';

		if($_args['method'] === 'post')
		{
			\lib\db\userteams::insert($args);
		}
		elseif($_args['method'] === 'patch')
		{
			$id = \dash\app::request('id');
			$id = \dash\coding::decode($id);
			if(!$id)
			{
				\dash\db\logs::set('api:gateway:pathc:id:not:set', \dash\user::id(), $log_meta);
				\dash\notif::error(T_("Id not set"), 'id', 'arguments');
				return false;
			}

			$check_user_in_team = \lib\db\userteams::get(['user_id' => $id, 'team_id' => $team_id, 'limit' => 1]);

			if(!$check_user_in_team || !isset($check_user_in_team['id']))
			{
				\dash\db\logs::set('api:gateway:user:not:in:team', \dash\user::id(), $log_meta);
				\dash\notif::error(T_("This user is not in this team"), 'id', 'arguments');
				return false;
			}

			unset($args['team_id']);

			if(!\dash\app::isset_request('status')) 		unset($args['status']);
			if(!\dash\app::isset_request('name')) 		unset($args['displayname']);
			if(!\dash\app::isset_request('rule')) 		unset($args['rule']);

			if(!empty($args))
			{
				\lib\db\userteams::update($args, $check_user_in_team['id']);
			}
			$update_user = [];

			if($password)
			{
				$update_user['password'] = $password;
			}

			if(\dash\app::isset_request('username'))
			{
				$update_user['username'] = $username;
			}

			if(!empty($update_user))
			{
				\dash\db\users::update($update_user, $id);
			}

		}
		elseif ($_args['method'] === 'delete')
		{
			// \lib\db\gateways::remove($args);
		}

		if(\dash\engine\process::status())
		{
			// \dash\notif::title(T_("Operation Complete"));

			if($_args['method'] === 'post')
			{
				\dash\notif::ok(T_("gateway successfully added"));
			}
			elseif($_args['method'] === 'patch')
			{
				\dash\notif::ok(T_("gateway successfully updated"));
			}
			else
			{
				\dash\notif::ok(T_("gateway successfully removed"));
			}
		}

	}
}
?>