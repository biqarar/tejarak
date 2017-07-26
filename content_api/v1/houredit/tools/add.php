<?php
namespace content_api\v1\houredit\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;
trait add
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
	public function add_houredit($_args = [])
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
			logs::set('api:houredit:user_id:not:set', null, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		$id         = utility::request('id'); // '3Fh'
		$start_date = utility\human::number(utility::request('start_date'), 'en'); // '۱۳۹۶-۰۴-۰۷'
		$start_time = utility\human::number(utility::request('start_time'), 'en'); // '۱۲:۲۸:۰۰'
		$end_date   = utility\human::number(utility::request('end_date'), 'en'); // ''
		$end_time   = utility\human::number(utility::request('end_time'), 'en'); // ''
		$desc       = utility::request('desc'); // ''

		$id = utility\shortURL::decode($id);
		if(utility::request('id') && !$id)
		{
			logs::set('api:houredit:id:not:set', null, $log_meta);
			debug::error(T_("Id not set"), 'id', 'arguments');
			return false;
		}

		if(!$start_date)
		{
			logs::set('api:houredit:start_date:not:set', null, $log_meta);
			debug::error(T_("Start date not set"), 'start_date', 'arguments');
			return false;
		}

		if(\DateTime::createFromFormat('Y-m-d', $start_date) === false)
		{
		 	logs::set('api:houredit:start_date:invalid', null, $log_meta);
			debug::error(T_("Invalid start date"), 'start_date', 'arguments');
			return false;
		}

		if(!$start_time)
		{
			logs::set('api:houredit:start_time:not:set', null, $log_meta);
			debug::error(T_("Start time not set"), 'start_time', 'arguments');
			return false;
		}

		if(\DateTime::createFromFormat('H:i', $start_time) === false)
		{
		 	logs::set('api:houredit:start_time:invalid', null, $log_meta);
			debug::error(T_("Invalid start time"), 'start_time', 'arguments');
			return false;
		}

		if(!$end_date)
		{
			logs::set('api:houredit:end_date:not:set', null, $log_meta);
			debug::error(T_("end date not set"), 'end_date', 'arguments');
			return false;
		}

		if(\DateTime::createFromFormat('Y-m-d', $end_date) === false)
		{
		 	logs::set('api:houredit:end_date:invalid', null, $log_meta);
			debug::error(T_("Invalid end date"), 'end_date', 'arguments');
			return false;
		}

		if(!$end_time)
		{
			logs::set('api:houredit:end_time:not:set', null, $log_meta);
			debug::error(T_("end time not set"), 'end_time', 'arguments');
			return false;
		}

		if(\DateTime::createFromFormat('H:i', $end_time) === false)
		{
		 	logs::set('api:houredit:end_time:invalid', null, $log_meta);
			debug::error(T_("Invalid end time"), 'end_time', 'arguments');
			return false;
		}

		if($desc && mb_strlen($desc) > 500)
		{
			logs::set('api:houredit:desc:max:length', null, $log_meta);
			debug::error(T_("You must be set less than 500 character in description field"), 'desc', 'arguments');
			return false;
		}

		$team_id = utility::request('team');
		$team_id = utility\shortURL::decode($team_id);
		if(!$team_id)
		{
			logs::set('api:houredit:team:id:not:set', null, $log_meta);
			debug::error(T_("Team id not set"), 'team', 'arguments');
			return false;
		}

		// the request have hour id
		if($id && utility::request('id'))
		{
			// load hour data
			$hour_detail = \lib\db\hours::access_hours_id($id, $this->user_id, ['action' => 'view']);

			// check the hour exist
			if(isset($hour_detail['id']))
			{
				$hour_id = $hour_detail['id'];
			}
			else
			{
				logs::set('api:houredit:hour:notfound:invalid', null, $log_meta);
				debug::error(T_("Can not access to set time of this hour"), 'hour', 'permission');
				return false;
			}
		}

		$update_mode = false;
		if(utility::request('id') && $id && is_numeric($id))
		{
			// get this hour id is set old or no
			$check_exist = \lib\db\hourrequests::get(['hour_id' => $id, 'limit' => 1]);
			if($check_exist)
			{
				if(isset($check_exist['id']))
				{
					$update_mode = true;
				}
				else
				{
					logs::set('api:houredit:hour:duplicate:insert:hour_id', null, $log_meta);
					debug::error(T_("You was already set this request"), 'id', 'arguments');
					return false;
				}
			}
		}
		else
		{
			// get this hour id is set old or no
			$check_exist = \lib\db\hourrequests::get(
			[
				'date'        => $start_date,
				'team_id'     => $team_id,
				'userteam_id' => "(SELECT id FROM userteams WHERE user_id = ". $this->user_id. " AND team_id = $team_id LIMIT 1)",
				'limit'       => 1
			]);

			if($check_exist)
			{
				logs::set('api:houredit:duplicate:start:date:hour_id:is:null', null, $log_meta);
				debug::error(T_("Duplicate request of this start time"), 'id', 'arguments');
				return false;
			}
		}

		$args                = [];
		$args['hour_id']     = $id ? $id : null;
		$args['date']        = $start_date;
		$args['start']       = $start_time;
		$args['end']         = $end_time;
		$args['enddate']     = $end_date;
		$args['desc']        = $desc;
		$args['creator']     = $this->user_id;
		$args['team_id']     = $team_id;
		$args['userteam_id'] = "(SELECT id FROM userteams WHERE user_id = ". $this->user_id. " AND team_id = $team_id LIMIT 1)";

		if($_args['method'] === 'post' && !$update_mode)
		{
			$houredit_id = \lib\db\hourrequests::insert($args);
		}
		elseif($update_mode)
		{
			unset($args['hour_id']);
			unset($args['creator']);
			$houredit_id = \lib\db\hourrequests::update($args, $check_exist['id']);
		}
		else
		{
			logs::set('api:houredit:method:error', null, $log_meta);
			debug::error(T_("Syste error"), 'system', 'error');
			return false;
		}

		if(debug::$status)
		{
			debug::title(T_("Operation complete"));
			if($update_mode)
			{
				debug::true(T_("Your request updated"));
			}
			else
			{
				debug::true(T_("Your request sended"));
			}
		}
	}
}
?>