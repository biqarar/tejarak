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
		$user = utility\shortURL::decode($user);

		if(!$user)
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
		$team_detail = \lib\db\teams::access_team($team, $this->user_id, ['action' => 'save_hours', 'change_hour_user' => $user]);

		// check the team exist
		if(isset($team_detail['id']))
		{
			$team_id = $team_detail['id'];
		}
		else
		{
			logs::set('api:hours:team:notfound:invalid', null, $log_meta);
			debug::error(T_("Can not access to set time of this team"), 'team', 'permission');
			return false;
		}

		// CHECK PERMISSION TO ADD TIME
		// if(\lib\db\teams::access_in_team_id($team_id, $this->user_id))

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
		$args['team_id']   = $team_id;
		$args['minus']     = $minus;
		$args['plus']      = $plus;
		$args['type']      = $type;

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