<?php
namespace content_api\v1\houredit\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;
trait action
{
	/**
	 * Adds houredit.
	 * add member time
	 * start or end of time save on this function and
	 * minus and plus time
	 * @param      array    $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function hourrequest_action($_args = [])
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
			logs::set('api:houredit:action:user_id:not:set', null, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}


		$id = utility::request('id');
		$id = utility\shortURL::decode($id);
		if(!$id)
		{
			logs::set('api:houredit:action:id:not:set', null, $log_meta);
			debug::error(T_("Id not set or invalid id"), 'id', 'arguments');
			return false;
		}

		$type = utility::request('type');
		if(!$type)
		{
			logs::set('api:houredit:action:type:not:set', null, $log_meta);
			debug::error(T_("Action type not set"), 'type', 'arguments');
			return false;
		}

		if(!in_array($type, ['accept', 'reject']))
		{
			logs::set('api:houredit:action:type:inavalid', null, $log_meta);
			debug::error(T_("Invalid action type"), 'type', 'arguments');
			return false;
		}

		$response = utility::request('response');
		if($response && mb_strlen($response) > 500)
		{
			logs::set('api:houredit:action:response:max:length', null, $log_meta);
			debug::error(T_("You can set less than 500 character in response"));
			return false;
		}

		$team_id = utility::request('team');
		$team_id = utility\shortURL::decode($team_id);
		if(!$team_id)
		{
			logs::set('api:houredit:action:team:id:not:set', null, $log_meta);
			debug::error(T_("Team id not set"), 'team', 'arguments');
			return false;
		}

		// check this user is admin of this team
		$access_team = \lib\db\teams::access_team_id($team_id, $this->user_id, ['action' => 'admin']);

		// check the hour exist
		if(!isset($access_team['id']))
		{
			logs::set('api:houredit:action:access:forbidden', null, $log_meta);
			debug::error(T_("Can not access to accept or reject hour edit request"), 'team', 'permission');
			return false;
		}

		$is_exist_record = \lib\db\hourrequests::get(['id' => $id, 'limit' => 1]);
		if(!$is_exist_record || !isset($is_exist_record['team_id']) || !isset($is_exist_record['creator']))
		{
			logs::set('api:houredit:id:record:not:found', null, $log_meta);
			debug::error(T_("Invaid id. record not found"), 'id', 'arguments');
			return false;
		}

		if(intval($is_exist_record['team_id']) === intval($team_id))
		{
			// no problem
		}
		else
		{
			logs::set('api:houredit:team:id:hourrequests:team_id:not:mathc', null, $log_meta);
			debug::error(T_("Invaid team id"), 'team', 'permission');
			return false;
		}

		// check this user is admin of this team
		$access_team_user = \lib\db\teams::access_team_id($team_id, $is_exist_record['creator'], ['action' => 'in_team']);

		// check the hour exist
		if(!isset($access_team_user['id']))
		{
			logs::set('api:houredit:action:access:forbidden:user:not:in:team', null, $log_meta);
			debug::error(T_("This user is not in this team"), 'team', 'permission');
			return false;
		}

		$update             = [];
		$update['response'] = $response;
		$update['status']   = $type;

		if($type === 'accept')
		{

		}

		\lib\db\hourrequests::update($update, $id);

		if(debug::$status)
		{
			debug::title(T_("Operation complete"));
			if($type === 'accept')
			{
				debug::true(T_("Request accepted"));
			}
			else
			{
				debug::warn(T_("Request rejected"));
			}
		}
	}
}
?>