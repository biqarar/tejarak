<?php
namespace content_api\v1\hours\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;
trait add
{

	/**
	 * Adds hours.
	 * add member time
	 * start or end of time save on this function and
	 * minus and plus time
	 * @param      array    $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function add_hours($_args = [])
	{
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
			logs::set('api:hours:user_id:notfound', null, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		$user = utility::request('user');
		if(!$user || !is_numeric($user))
		{
			logs::set('api:hours:user:notfound', $this->user_id, $log_meta);
			debug::error(T_("Member not found"), 'user', 'arguments');
			return false;
		}


		// get team and check it
		$team = utility::request('team');
		if(!$team)
		{
			logs::set('api:hours:team:notfound', null, $log_meta);
			debug::error(T_("Team not found"), 'team', 'permission');
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
			logs::set('api:hours:team:notfound:invalid', null, $log_meta);
			debug::error(T_("Team not found"), 'team', 'permission');
			return false;
		}

		// check team boos is the user id
		if(isset($team_detail['boss']) && intval($team_detail['boss']) === intval($this->user_id))
		{
			// no problem to add hours fo this team
		}
		else
		{
			logs::set('api:hours:team:permission', null, $log_meta);
			debug::error(T_("Permission denide to add hours of this team"), 'user', 'permission');
			return false;
		}


		// get date exit
		$branch   = utility::request('branch');
		if(!$branch)
		{
			logs::set('api:hours:branch:notfound', null, $log_meta);
			debug::error(T_("Branch not found"), 'branch', 'permission');
			return false;
		}

		if($load_branch = \lib\db\branchs::get_by_brand($team, $branch))
		{
			if(isset($load_branch['id']))
			{
				$branch_id = $load_branch['id'];
			}
			else
			{
				logs::set('api:hours:branch:invalid', null, $log_meta);
				debug::error(T_("Invalid branch"), 'branch', 'permission');
				return false;
			}
		}

		$type = utility::request('type');
		if(!$type || !in_array($type, ['enter', 'exit']))
		{
			logs::set('api:hours:type:notfound', $this->type_id, $log_meta);
			debug::error(T_("Invalid arguments type"), 'type', 'arguments');
			return false;
		}

		$minus = utility::request('minus');
		if($minus && !is_numeric($minus))
		{
			logs::set('api:hours:minus:notfound', $this->user_id, $log_meta);
			debug::error(T_("Member not found"), 'minus', 'arguments');
			return false;
		}

		$plus = utility::request('plus');
		if($plus && !is_numeric($plus))
		{
			logs::set('api:hours:plus:notfound', $this->user_id, $log_meta);
			debug::error(T_("Member not found"), 'plus', 'arguments');
			return false;
		}

		$type = utility::request('type');
		if(!$type)
		{
			logs::set('api:hours:type:notset', $this->user_id, $log_meta);
			debug::error(T_("Type not set"), 'type', 'arguments');
			return false;
		}

		if(!in_array($type, ['enter', 'exit']))
		{
			logs::set('api:hours:type:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid arguments type"), 'type', 'arguments');
			return false;
		}

		$args              = [];
		$args['user_id']   = $user;
		$args['minus']     = $minus;
		$args['plus']      = $plus;
		$args['type']      = $type;
		$args['team_id']   = $team_id;
		$args['branch_id'] = $branch_id;

		if($_args['method'] === 'post')
		{
			if($type === 'enter')
			{
				// save hours
				$hours_id = \lib\db\hours::save_enter($args);
			}
			else
			{
				$hours_id = \lib\db\hours::save_exit($args);
			}
		}
		else
		{
			logs::set('api:hours:method:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid method of api"), 'method', 'permission');
			return false;
		}

		if(debug::$status)
		{
			debug::title(T_("Operation Complete"));
			if($type === 'enter')
			{
				debug::true(T_("Hi Dear ;)"));
			}
			else
			{
				debug::true(T_("ByeBye :("));
			}
		}
	}
}
?>