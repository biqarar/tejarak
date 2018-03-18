<?php
namespace content_api\v1\houredit\tools;


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

		\lib\notif::title(T_("Operation Faild"));

		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => \lib\utility::request(),
			]
		];

		if(!$this->user_id)
		{
			\lib\db\logs::set('api:houredit:action:user_id:not:set', $this->user_id, $log_meta);
			\lib\notif::error(T_("User not found"), 'user', 'permission');
			return false;
		}


		$id = \lib\utility::request('id');
		$id = \lib\utility\shortURL::decode($id);
		if(!$id)
		{
			\lib\db\logs::set('api:houredit:action:id:not:set', $this->user_id, $log_meta);
			\lib\notif::error(T_("Id not set or invalid id"), 'id', 'arguments');
			return false;
		}

		$type = \lib\utility::request('type');
		if(!$type)
		{
			\lib\db\logs::set('api:houredit:action:type:not:set', $this->user_id, $log_meta);
			\lib\notif::error(T_("Action type not set"), 'type', 'arguments');
			return false;
		}

		if(!in_array($type, ['accept', 'reject']))
		{
			\lib\db\logs::set('api:houredit:action:type:inavalid', $this->user_id, $log_meta);
			\lib\notif::error(T_("Invalid action type"), 'type', 'arguments');
			return false;
		}

		$response = \lib\utility::request('response');
		if($response && mb_strlen($response) > 500)
		{
			\lib\db\logs::set('api:houredit:action:response:max:length', $this->user_id, $log_meta);
			\lib\notif::error(T_("You can set less than 500 character in response"));
			return false;
		}

		$team_id = \lib\utility::request('team');
		$team_id = \lib\utility\shortURL::decode($team_id);
		if(!$team_id)
		{
			\lib\db\logs::set('api:houredit:action:team:id:not:set', $this->user_id, $log_meta);
			\lib\notif::error(T_("Team id not set"), 'team', 'arguments');
			return false;
		}

		// check this user is admin of this team
		$access_team = \lib\db\teams::access_team_id($team_id, $this->user_id, ['action' => 'admin']);

		// check the hour exist
		if(!isset($access_team['id']))
		{
			\lib\db\logs::set('api:houredit:action:access:forbidden', $this->user_id, $log_meta);
			\lib\notif::error(T_("Can not access to accept or reject hour edit request"), 'team', 'permission');
			return false;
		}

		$is_exist_record = \lib\db\hourrequests::get(['id' => $id, 'limit' => 1]);
		if(!$is_exist_record || !isset($is_exist_record['team_id']) || !isset($is_exist_record['creator']) || !isset($is_exist_record['status']))
		{
			\lib\db\logs::set('api:houredit:id:record:not:found', $this->user_id, $log_meta);
			\lib\notif::error(T_("Invaid id. record not found"), 'id', 'arguments');
			return false;
		}

		if($is_exist_record['status'] != 'awaiting')
		{
			\lib\db\logs::set('api:houredit:id:record:is:not:awaiting', $this->user_id, $log_meta);
			\lib\notif::error(T_("This request has already been reviewed"), 'id', 'arguments');
			return false;
		}

		if(intval($is_exist_record['team_id']) === intval($team_id))
		{
			// no problem
		}
		else
		{
			\lib\db\logs::set('api:houredit:team:id:hourrequests:team_id:not:mathc', $this->user_id, $log_meta);
			\lib\notif::error(T_("Invaid team id"), 'team', 'permission');
			return false;
		}

		// check this user is admin of this team
		$access_team_user = \lib\db\teams::access_team_id($team_id, $is_exist_record['creator'], ['action' => 'in_team']);

		// check the hour exist
		if(!isset($access_team_user['id']))
		{
			\lib\db\logs::set('api:houredit:action:access:forbidden:user:not:in:team', $this->user_id, $log_meta);
			\lib\notif::error(T_("This user is not in this team"), 'team', 'permission');
			return false;
		}

		$update             = [];
		$update['response'] = $response;
		$update['status']   = $type;
		$update['changer']  = $this->user_id;

		$meta               = [];

		if($type === 'accept')
		{
			// the request hava hour id
			// need to update hour record
			$hourrequests_details = $is_exist_record;
			if(isset($hourrequests_details['hour_id']) && $hourrequests_details['hour_id'] && is_numeric($hourrequests_details['hour_id']))
			{
				$hour_detail = \lib\db\hours::get(['id' => $hourrequests_details['hour_id'], 'limit' => 1]);
				if(!isset($hour_detail['id']))
				{
					\lib\db\logs::set('api:houredit:action:hour_id:set:but:not:found', $this->user_id, $log_meta);
					\lib\notif::error(T_("Hour id not found!"), 'id', 'system');
					return false;
				}

				$log_meta['meta']['hourrequests_details'] = $hourrequests_details;
				$log_meta['meta']['hour_detail']          = $hour_detail;
				\lib\db\hours::record_process($hourrequests_details, $hour_detail['id'], ['hour_detail' => $hour_detail, 'type' => 'update']);
				\lib\db\logs::set('api:hour:edited:request:accepted', $this->user_id, $log_meta);
			}
			else
			{
				// hour request have not hour id
				// need to add new record
				\lib\db\hours::record_process($hourrequests_details, null, ['type' => 'insert', 'user_id' => $this->user_id]);
				$meta['inserted_hour_id'] = \lib\db::insert_id();
				\lib\db\logs::set('api:hour:added:request:accepted', $this->user_id, $log_meta);
			}
		}

		if(!empty($meta))
		{
			$update['meta'] = json_encode($meta, JSON_UNESCAPED_UNICODE);
		}

		\lib\db\hourrequests::update($update, $id);

		if(\lib\notif::$status)
		{
			\lib\notif::title(T_("Operation complete"));
			if($type === 'accept')
			{
				\lib\notif::ok(T_("Request accepted"));
			}
			else
			{
				\lib\notif::warn(T_("Request rejected"));
			}
		}
	}
}
?>