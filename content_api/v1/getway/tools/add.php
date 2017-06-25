<?php
namespace content_api\v1\getway\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait add
{


	/**
	 * Adds a getway.
	 *
	 * @param      array    $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function add_getway($_args = [])
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

		// delete getway mode
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

		// check user id is exist
		if(!$this->user_id)
		{
			logs::set('api:getway:user_id:notfound', null, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		// get team and check it
		$team = utility::request('team');
		$team = utility\shortURL::decode($team);
		if(!$team)
		{
			logs::set('api:getway:team:not:set', null, $log_meta);
			debug::error(T_("Team not set"), 'user', 'permission');
			return false;
		}
		// load team data
		$team_detail = \lib\db\teams::access_team_id($team, $this->user_id, ['action' => 'add_getway']);
		// check the team exist
		if(isset($team_detail['id']))
		{
			$team_id = $team_detail['id'];
		}
		else
		{
			logs::set('api:getway:team:notfound:invalid', null, $log_meta);
			debug::error(T_("Team not found"), 'user', 'permission');
			return false;
		}

		// get firstname
		$name = utility::request("name");
		$name = trim($name);
		if($name && mb_strlen($name) > 50)
		{
			logs::set('api:getway:name:max:length', $this->user_id, $log_meta);
			debug::error(T_("You can set the name less than 50 character"), 'name', 'arguments');
			return false;
		}

		if(!$name)
		{
			logs::set('api:getway:name:not:set', $this->user_id, $log_meta);
			debug::error(T_("The getway name can not be null"), 'name', 'arguments');
			return false;
		}

		$displayname = $name;

		// get firstname
		$ip = utility::request("ip");
		$ip = trim($ip);
		if($ip && mb_strlen($ip) > 50)
		{
			logs::set('api:getway:ip:max:length', $this->user_id, $log_meta);
			debug::error(T_("You can set the ip less than 50 character"), 'ip', 'arguments');
			return false;
		}
		$firstname = $ip;


		// get lastname
		$agent = utility::request("agent");
		$agent = trim($agent);
		if($agent && mb_strlen($agent) > 90)
		{
			logs::set('api:getway:agent:max:length', $this->user_id, $log_meta);
			debug::error(T_("You can set the agent less than 90 character"), 'agent', 'arguments');
			return false;
		}
		$lastname = $agent;

		$username = null;
		$user_id  = null;

		if($_args['method'] === 'post')
		{
			$insert_users =
			[
				'user_parent'      => $this->user_id,
				'user_createdate'  => date("Y-m-d H:i:s"),
				'user_displayname' => $displayname,
			];
			\lib\db\users::insert($insert_users);
			$user_id = \lib\db::insert_id();

			if($user_id)
			{
				$username = 'g-'. utility\shortURL::encode($user_id);
				$update_user =
				[
					'user_username' => $username
				];
				\lib\db\users::update($update_user, $user_id);
			}
		}
		elseif($_args['method'] === 'patch')
		{
			$id = utility::request('id');
			$user_id = utility\shortURL::decode($id);
			if($user_id)
			{
				$check_user_is_getway = \lib\db\userteams::get(['user_id' => $user_id, 'rule' => 'getway', 'limit' => 1]);
				if(!$check_user_is_getway)
				{
					logs::set('api:getway:user_id:is:not:getway:user', $this->user_id, $log_meta);
					debug::error(T_("User id is not a getway user!"), 'user', 'permission');
					return false;
				}
			}
		}


		if(!$user_id)
		{
			logs::set('api:getway:user_id:not:found:and:cannot:signup', $this->user_id, $log_meta);
			debug::error(T_("User id not found"), 'user', 'system');
			return false;
		}
		// to redirect site in new url
		\lib\storage::set_new_user_code(utility\shortURL::encode($user_id));

		// get status
		$status = utility::request('status');
		if($status)
		{
			if(!in_array($status, ['active', 'deactive', 'disable']))
			{
				logs::set('api:getway:status:invalid', $this->user_id, $log_meta);
				debug::error(T_("Invalid parameter status"), 'status', 'arguments');
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
		$args['firstname']     = $firstname;
		$args['lastname']      = $lastname;
		$args['status']        = $status;
		$args['rule']          = 'getway';

		if($_args['method'] === 'post')
		{
			\lib\db\userteams::insert($args);
		}
		elseif($_args['method'] === 'patch')
		{
			$id = utility::request('id');
			$id = utility\shortURL::decode($id);
			if(!$id)
			{
				logs::set('api:getway:pathc:id:not:set', $this->user_id, $log_meta);
				debug::error(T_("Id not set"), 'id', 'arguments');
				return false;
			}

			$check_user_in_team = \lib\db\userteams::get(['user_id' => $id, 'team_id' => $team_id, 'limit' => 1]);

			if(!$check_user_in_team || !isset($check_user_in_team['id']))
			{
				logs::set('api:getway:user:not:in:team', $this->user_id, $log_meta);
				debug::error(T_("This user is not in this team"), 'id', 'arguments');
				return false;
			}

			unset($args['team_id']);

			if(!utility::isset_request('ip')) 			unset($args['firstname']);
			if(!utility::isset_request('agent')) 		unset($args['lastname']);
			if(!utility::isset_request('status')) 		unset($args['status']);
			if(!utility::isset_request('name')) 		unset($args['displayname']);
			if(!utility::isset_request('rule')) 		unset($args['rule']);

			if(!empty($args))
			{
				\lib\db\userteams::update($args, $check_user_in_team['id']);
			}
		}
		elseif ($_args['method'] === 'delete')
		{
			// \lib\db\getways::remove($args);
		}

		if(debug::$status)
		{
			debug::title(T_("Operation Complete"));

			if($_args['method'] === 'post')
			{
				debug::true(T_("Getway successfully added"));
			}
			elseif($_args['method'] === 'patch')
			{
				debug::true(T_("Getway successfully updated"));
			}
			else
			{
				debug::true(T_("Getway successfully removed"));
			}
		}

	}
}
?>