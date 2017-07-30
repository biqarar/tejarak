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

		$id         = utility::request('id');
		$start_date = utility\human::number(utility::request('start_date'), 'en');
		$start_time = utility\human::number(utility::request('start_time'), 'en');
		$end_date   = utility\human::number(utility::request('end_date'), 'en');
		$end_time   = utility\human::number(utility::request('end_time'), 'en');
		$desc       = utility::request('desc');

		$id = utility\shortURL::decode($id);
		if(utility::request('id') && !$id)
		{
			logs::set('api:houredit:id:not:set', $this->user_id, $log_meta);
			debug::error(T_("Id not set"), 'id', 'arguments');
			return false;
		}

		if(!$start_date)
		{
			logs::set('api:houredit:start_date:not:set', $this->user_id, $log_meta);
			debug::error(T_("Start date not set"), 'start_date', 'arguments');
			return false;
		}

		if(\DateTime::createFromFormat('Y-m-d', $start_date) === false)
		{
		 	logs::set('api:houredit:start_date:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid start date"), 'start_date', 'arguments');
			return false;
		}

		if(!$start_time)
		{
			logs::set('api:houredit:start_time:not:set', $this->user_id, $log_meta);
			debug::error(T_("Start time not set"), 'start_time', 'arguments');
			return false;
		}

		if(\DateTime::createFromFormat('H:i', $start_time) === false && \DateTime::createFromFormat('H:i:s', $start_time) === false)
		{
		 	logs::set('api:houredit:start_time:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid start time"), 'start_time', 'arguments');
			return false;
		}

		if(!$end_date)
		{
			logs::set('api:houredit:end_date:not:set', $this->user_id, $log_meta);
			debug::error(T_("end date not set"), 'end_date', 'arguments');
			return false;
		}

		if(\DateTime::createFromFormat('Y-m-d', $end_date) === false)
		{
		 	logs::set('api:houredit:end_date:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid end date"), 'end_date', 'arguments');
			return false;
		}

		if(!$end_time)
		{
			logs::set('api:houredit:end_time:not:set', $this->user_id, $log_meta);
			debug::error(T_("end time not set"), 'end_time', 'arguments');
			return false;
		}

		if(\DateTime::createFromFormat('H:i', $end_time) === false && \DateTime::createFromFormat('H:i:s', $end_time) === false)
		{
		 	logs::set('api:houredit:end_time:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid end time"), 'end_time', 'arguments');
			return false;
		}

		if($desc && mb_strlen($desc) > 500)
		{
			logs::set('api:houredit:desc:max:length', $this->user_id, $log_meta);
			debug::error(T_("You must be set less than 500 character in description field"), 'desc', 'arguments');
			return false;
		}

		$team_id = utility::request('team');
		$team_id = utility\shortURL::decode($team_id);
		if(!$team_id)
		{
			logs::set('api:houredit:team:id:not:set', $this->user_id, $log_meta);
			debug::error(T_("Team id not set"), 'team', 'arguments');
			return false;
		}
		// get userteam detail
		$userteam_detail = \lib\db\teams::access_team_id($team_id, $this->user_id, ['action' => 'in_team']);

		if(!isset($userteam_detail['userteam_createdate']))
		{
			logs::set('api:houredit:userteam:id:not:found', $this->user_id, $log_meta);
			debug::error(T_("This user is not in this team"), 'team', 'arguments');
			return false;
		}
		// get the first date this user added to this team
		$date_added_to_team = $userteam_detail['userteam_createdate'];
		// set gregorian date
		$start_date_gregorian = $start_date;
		// if start date is jalali convert to gregorian
		if(utility\jdate::is_jalali($start_date))
		{
			$start_date_gregorian = utility\jdate::to_gregorian($start_date, "Y-m-d");
		}

		// check start date > date added user in team
		if(strtotime($start_date_gregorian) < strtotime($date_added_to_team))
		{
			logs::set('api:houredit:start:date:less:than:added:to:team', $this->user_id, $log_meta);
			debug::error(T_("On this time you are not in this team!"), 'start_date', 'arguments');
			return false;
		}

		// set gregorian date
		$end_date_gregorian = $end_date;
		// if end date is jalali convert to gregorian
		if(utility\jdate::is_jalali($end_date))
		{
			$end_date_gregorian = utility\jdate::to_gregorian($end_date, "Y-m-d");
		}

		// check end date > date added user in team
		if(strtotime($end_date_gregorian) > time())
		{
			logs::set('api:houredit:end:date:larger:than:now', $this->user_id, $log_meta);
			debug::error(T_("End date can not be in the future"), 'end_date', 'arguments');
			return false;
		}

		// check end date > start date
		if(strtotime($end_date_gregorian) < strtotime($start_date_gregorian))
		{
			logs::set('api:houredit:end:date:larger:start:date', $this->user_id, $log_meta);
			debug::error(T_("End date can not larger than start date"), 'end_date', 'arguments');
			return false;
		}

		// check start and end time in one date
		if(strtotime($end_date_gregorian) === strtotime($start_date_gregorian))
		{
			if(strtotime("$end_date_gregorian $end_time") < strtotime("$start_date_gregorian $start_time"))
			{
				logs::set('api:houredit:end:time:larger:start:time:date:is:equal', $this->user_id, $log_meta);
				debug::error(T_("Can not set end time larger than start time in one date"), 'end_time', 'arguments');
				return false;
			}
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
				logs::set('api:houredit:hour:notfound:invalid', $this->user_id, $log_meta);
				debug::error(T_("Can not access to set time of this hour"), 'hour', 'permission');
				return false;
			}

			// check one of the request was change
			if(isset($hour_detail['date']) && isset($hour_detail['start']) && isset($hour_detail['end']) && isset($hour_detail['enddate']))
			{
				if
				(
					strtotime("$hour_detail[date] $hour_detail[start]") === strtotime("$start_date_gregorian $start_time") &&
					strtotime("$hour_detail[enddate] $hour_detail[end]") === strtotime("$end_date_gregorian $end_time")
				)
				{
					logs::set('api:houredit:hour:no:thing:edit', $this->user_id, $log_meta);
					debug::error(T_("No thing changed!"), null, 'arguments');
					return false;
				}
			}

		}

		$update_mode = false;
		// if the hourrequest have hour id
		// check the user on this hour id hava any awaiting request
		// if hava awaiting request update it
		// and if not have insert new
		if(utility::request('id') && $id && is_numeric($id))
		{
			// get this hour id is set old or no
			$check_exist = \lib\db\hourrequests::get(['hour_id' => $id, 'status' => 'awaiting', 'limit' => 1]);

			if(isset($check_exist['id']))
			{
				$update_mode = true;
			}
		}
		else
		{
			// get this hour id is set old or no
			$check_exist = \lib\db\hourrequests::get(
			[
				'date'        => $start_date,
				'team_id'     => $team_id,
				'status'      => 'awaiting',
				'userteam_id' => "(SELECT id FROM userteams WHERE user_id = ". $this->user_id. " AND team_id = $team_id LIMIT 1)",
				'limit'       => 1
			]);

			if($check_exist)
			{
				logs::set('api:houredit:duplicate:start:date:hour_id:is:null', $this->user_id, $log_meta);
				debug::error(T_("Duplicate request of this start time"), 'id', 'arguments');
				return false;
			}
		}

		$args                    = [];
		$args['hour_id']         = $id ? $id : null;
		// start date gregorian
		$args['date']            = $start_date_gregorian;
		$args['year']            = date("Y", strtotime($start_date_gregorian));
		$args['month']           = date("m", strtotime($start_date_gregorian));
		$args['day']             = date("d", strtotime($start_date_gregorian));
		// start date shamsi
		$args['shamsi_date']     = utility\jdate::date("Y-m-d", strtotime($start_date_gregorian), false, true);
		$args['shamsi_year']     = utility\jdate::date("Y", strtotime($start_date_gregorian), false, true);
		$args['shamsi_month']    = utility\jdate::date("m", strtotime($start_date_gregorian), false, true);;
		$args['shamsi_day']      = utility\jdate::date("d", strtotime($start_date_gregorian), false, true);;
		// start time
		$args['start']           = $start_time;
		// end time
		$args['end']             = $end_time;
		// end date gregorian
		$args['enddate']         = $end_date_gregorian;
		$args['endyear']         = date("Y", strtotime($end_date_gregorian));
		$args['endmonth']        = date("m", strtotime($end_date_gregorian));
		$args['endday']          = date("d", strtotime($end_date_gregorian));
		// enddate shamsi
		$args['endshamsi_date']  = utility\jdate::date("Y-m-d", strtotime($end_date_gregorian), false, true);
		$args['endshamsi_year']  = utility\jdate::date("Y", strtotime($end_date_gregorian), false, true);
		$args['endshamsi_month'] = utility\jdate::date("m", strtotime($end_date_gregorian), false, true);
		$args['endshamsi_day']   = utility\jdate::date("d", strtotime($end_date_gregorian), false, true);
		// other field
		$args['desc']            = $desc;
		$args['creator']         = $this->user_id;
		$args['team_id']         = $team_id;
		$args['userteam_id']     = "(SELECT id FROM userteams WHERE user_id = ". $this->user_id. " AND team_id = $team_id LIMIT 1)";

		if($_args['method'] === 'post' && !$update_mode)
		{
			$houredit_id = \lib\db\hourrequests::insert($args);
		}
		elseif($update_mode)
		{
			$houredit_id = \lib\db\hourrequests::update($args, $check_exist['id']);
		}
		else
		{
			logs::set('api:houredit:method:error', $this->user_id, $log_meta);
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