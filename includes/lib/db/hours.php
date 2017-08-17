<?php
namespace lib\db;
use \lib\db;
use \lib\utility\jdate;
use \lib\debug;
use \lib\utility;

class hours
{

	use hours\search;
	use hours\sum;
	use hours\month;
	use hours\period;

	/**
	 * insert new record in hours table
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		return db\config::public_insert('hours', ...func_get_args());
	}


	/**
	 * get
	 *
	 * @param      <type>  $_where  The where
	 */
	public static function get()
	{
		return db\config::public_get('hours', ...func_get_args());
	}


	/**
	 * update
	 *
	 * @param      <type>  $_where  The where
	 */
	public static function update()
	{
		return db\config::public_update('hours', ...func_get_args());
	}


	/**
	 * load one hours record details
	 *
	 * @param      <type>  $_id       The identifier
	 * @param      <type>  $_user_id  The user identifier
	 * @param      array   $_options  The options
	 */
	public static function access_hours_id($_id, $_user_id , $_options = [])
	{
		if(!$_id || !is_numeric($_id) || !$_user_id || !is_numeric($_user_id))
		{
			return false;
		}

		$query =
		"
			SELECT
				hours.*
			FROM hours
			INNER JOIN userteams ON userteams.id = hours.userteam_id
			WHERE
				hours.id = $_id AND
				userteams.user_id = $_user_id
			LIMIT 1
		";
		$result = \lib\db::get($query, null, true);
		return $result;
	}


	/**
	 * get count on online users
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function enter($_team_id)
	{
		if(!$_team_id || !is_numeric($_team_id))
		{
			return false;
		}

		$date  = date("Y-m-d");
		$query =
		"
			SELECT
				count(hours.id) AS `total`
			FROM
				hours
			INNER JOIN userteams ON userteams.id = hours.userteam_id AND userteams.team_id = $_team_id
			WHERE
				hours.date    = '$date'
			LIMIT 1
		";

		$total = \lib\db::get($query, "total", true);
		// return result as number of live users
		return $total;
	}

	/**
	 * get count on online users
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function live($_team_id)
	{
		if(!$_team_id || !is_numeric($_team_id))
		{
			return false;
		}

		$date = date("Y-m-d");
		$query =
		"
			SELECT
				COUNT(hours.id) AS `total`
			FROM
				hours
			INNER JOIN userteams ON userteams.id = hours.userteam_id
			WHERE
				userteams.team_id = $_team_id AND
				hours.date = '$date' AND
				hours.end IS NULL
			LIMIT 1
		";
		$total = \lib\db::get($query, "total", true);
		// return result as number of live users
		return $total;
	}


	/**
	 * presence on date
	 */
	public static function peresence($_team_id, $_date = null)
	{
		if(!$_team_id || !is_numeric($_team_id))
		{
			return false;
		}

		if($_date == null)
		{
			$_date = strtotime('now');
			$_date = date("Y-m-d", $_date);
		}

		$query =
		"
			SELECT
				userteams.displayname AS `name`,
				sum(hours.accepted) as 'accepted',
				sum(hours.diff) as 'diff'
			FROM
				hours
			INNER JOIN userteams ON userteams.id = hours.userteam_id AND userteams.team_id = $_team_id
			WHERE
				hours.date = '$_date'
			GROUP BY name
			ORDER BY accepted DESC
		";
		$peresence = \lib\db::get($query, ['name', 'accepted'] );
		return $peresence;
	}

	/**
	 * update time and change diff total , ....
	 *
	 * @param      <type>  $_args  The arguments
	 * @param      <type>  $_id    The identifier
	 */
	public static function record_process($_args, $_id = null, $_options = [])
	{
		$update_insert = [];

		if(isset($_args['start']) && isset($_args['date']) && isset($_args['end']) && isset($_args['enddate']))
		{
			$start = $_args['date'] . ' '. $_args['start'];
			$end   = $_args['enddate'] . ' '. $_args['end'];
			$diff  = round((strtotime($end) - strtotime($start)) / 60);

			$plus = 0;
			if(isset($_options['hour_detail']['plus']))
			{
				$plus = intval($_options['hour_detail']['plus']);
			}

			$minus = 0;
			if(isset($_options['hour_detail']['minus']))
			{
				$minus = intval($_options['hour_detail']['minus']);
			}

			$total = ((int) $diff + (int) $plus) - (int) $minus;

			$update_insert['diff']            = $diff;
			$update_insert['accepted']        = $total;
			$update_insert['total']           = $total;

		}

		if(isset($_args['date'])) 				$update_insert['date']            = $_args['date'];
		if(isset($_args['year'])) 				$update_insert['year']            = $_args['year'];
		if(isset($_args['month'])) 				$update_insert['month']           = $_args['month'];
		if(isset($_args['day'])) 				$update_insert['day']             = $_args['day'];
		if(isset($_args['shamsi_date'])) 		$update_insert['shamsi_date']     = $_args['shamsi_date'];
		if(isset($_args['shamsi_year'])) 		$update_insert['shamsi_year']     = $_args['shamsi_year'];
		if(isset($_args['shamsi_month'])) 		$update_insert['shamsi_month']    = $_args['shamsi_month'];
		if(isset($_args['shamsi_day'])) 		$update_insert['shamsi_day']      = $_args['shamsi_day'];
		if(isset($_args['start'])) 				$update_insert['start']           = $_args['start'];
		if(isset($_args['end'])) 				$update_insert['end']             = $_args['end'];
		if(isset($_args['enddate'])) 			$update_insert['enddate']         = $_args['enddate'];
		if(isset($_args['endyear'])) 			$update_insert['endyear']         = $_args['endyear'];
		if(isset($_args['endmonth'])) 			$update_insert['endmonth']        = $_args['endmonth'];
		if(isset($_args['endday'])) 			$update_insert['endday']          = $_args['endday'];
		if(isset($_args['endshamsi_date'])) 	$update_insert['endshamsi_date']  = $_args['endshamsi_date'];
		if(isset($_args['endshamsi_year'])) 	$update_insert['endshamsi_year']  = $_args['endshamsi_year'];
		if(isset($_args['endshamsi_month'])) 	$update_insert['endshamsi_month'] = $_args['endshamsi_month'];
		if(isset($_args['endshamsi_day'])) 		$update_insert['endshamsi_day']   = $_args['endshamsi_day'];
		if(isset($_args['start_time'])) 		$update_insert['start_time']   	  = $_args['start_time'];
		if(isset($_args['end_time'])) 			$update_insert['end_time']   	  = $_args['end_time'];

		if(isset($_options['type']) && $_options['type'] === 'update' && $_id && is_numeric($_id))
		{
			return self::update($update_insert, $_id);
		}
		elseif(isset($_options['type']) && $_options['type'] === 'insert')
		{
			if(!isset($_args['team_id']) || !isset($_args['userteam_id']) || !isset($_args['creator']) || !isset($_options['user_id']))
			{
				return false;
			}

			$update_insert['team_id']           = $_args['team_id'];
			$update_insert['userteam_id']       = $_args['userteam_id'];
			$update_insert['user_id']           = $_args['creator'];
			$update_insert['start_userteam_id'] = $_args['userteam_id'];
			$update_insert['start_gateway_id']  = $_options['user_id'];
			return self::insert($update_insert);
		}
		else
		{
			return false;
		}
	}


	/**
	 * check some data before save hours
	 *
	 * @param      <type>  $_args  The arguments
	 */
	private static function check_before_save($_args)
	{
		$date = date("Y-m-d");

		$userteam_id   = \lib\db\userteams::get(
			[
				'team_id' => $_args['team_id'],
				'user_id' => $_args['user_id'],
				'limit'   => 1,
			]
		);

		if(!$userteam_id || !isset($userteam_id['id']) || !isset($userteam_id['status']))
		{
			debug::error(T_("User team not found!"));
			return false;
		}

		if($userteam_id['status'] !== 'active')
		{
			debug::error(T_("User is diactive!"));
			return false;
		}

		$_args['userteam_id']      = $userteam_id['id'];
		$_args['userteam_details'] = $userteam_id;
		$_args['date']             = $date;

		return $_args;
	}


	/**
	 * Saves an enter.
	 * save enter time of user
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function save_enter($_args)
	{
		$date = date("Y-m-d");

		$_args = self::check_before_save($_args);

		if(!debug::$status)
		{
			return false;
		}
		// get last not exit time of this user and this teamd
		$in_use_time = self::in_use_time($_args);

		if($in_use_time && isset($in_use_time['end']) && !$in_use_time['end'])
		{
			debug::error(T_("You was already save your enter time"));
			return false;
		}

		if(isset($_args['userteam_details']['allowplus']) && $_args['userteam_details']['allowplus'])
		{

		}
		else
		{
			$_args['plus'] = null;
		}

		if(isset($_args['userteam_details']['displayname']))
		{
			\lib\storage::set_enter_exit_name($_args['userteam_details']['displayname']);
		}

		$insert                      = [];
		$insert['plus']              = $_args['plus'];
		$insert['user_id']           = $_args['user_id'];
		$insert['team_id']           = $_args['team_id'];
		$insert['start_userteam_id'] = $_args['userteam_id'];
		$insert['userteam_id']       = $_args['userteam_id'];
		$insert['date']              = date("Y-m-d");
		$insert['year']              = date("Y");
		$insert['month']             = date("m");
		$insert['day']               = date("d");
		$insert['shamsi_date']       = jdate::date("Y-m-d", strtotime($date), false, true);
		$insert['shamsi_year']       = jdate::date("Y", strtotime($date), false, true);
		$insert['shamsi_month']      = jdate::date("m", strtotime($date), false, true);
		$insert['shamsi_day']        = jdate::date("d", strtotime($date), false, true);
		$insert['start']             = date("H:i");
		$insert['start_gateway_id']  = $_args['gateway'];
		$insert['start_time']        = date("Y-m-d H:i:s");

		$inserted                        = self::insert($insert);
		$plan_feature                    = [];
		$plan_feature['type']            = 'enter';
		$plan_feature['inserted_record'] = $insert;
		$plan_feature['args']            = $_args;
		$plan_feature['in_use_time']     = $in_use_time;

		\lib\utility\plan::check_feature($plan_feature);

		return $inserted;
	}


	/**
	 * save exit time of user
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function save_exit($_args)
	{
		$date = date("Y-m-d");

		$_args = self::check_before_save($_args);

		if(!debug::$status)
		{
			return false;
		}

		// get last not exit time of this user and this teamd
		$start = self::in_use_time($_args);

		if(!$start || ($start && isset($start['end']) && $start['end']))
		{
			debug::error(T_("You was not save your enter time"));
			return ;
		}

		$check = true;

		if(!isset($start['start'])) $check = false;
		if(!isset($start['date'])) $check = false;
		if(!isset($start['id'])) $check = false;

		if(!$check)
		{
			debug::error(T_("Invalid data"));
			return false;
		}

		if(isset($_args['userteam_details']['allowminus']) && $_args['userteam_details']['allowminus'])
		{

		}
		else
		{
			$_args['minus'] = null;
		}

		if(isset($_args['userteam_details']['displayname']))
		{
			\lib\storage::set_enter_exit_name($_args['userteam_details']['displayname']);
		}

		$update = [];

		$start_time = $start['date'] . ' '. $start['start'];

		$start_time = strtotime($start_time);
		$end_time   = strtotime(date("Y-m-d H:i:s"));
		$diff       = round(($end_time - $start_time) / 60);

		$plus = 0;
		if(isset($start['plus']))
		{
			$plus = intval($start['plus']);
		}

		$total = ((int) $diff + (int) $plus) - (int) $_args['minus'];

		if($plus < 0) $plus = 0;
		if($diff < 0) $diff = 0;
		if($total < 0) $total = 0;

		$update['total']           = $total;
		$update['accepted']        = $total;
		$update['status']          = 'awaiting';
		$update['end']             = date("H:i");
		$update['diff']            = $diff;
		$update['minus']           = $_args['minus'];
		$update['enddate']         = date("Y-m-d");
		$update['endyear']         = date("Y");
		$update['endmonth']        = date("m");
		$update['endday']          = date("d");
		$update['endshamsi_date']  = jdate::date("Y-m-d", strtotime($date), false, true);
		$update['endshamsi_year']  = jdate::date("Y", strtotime($date), false, true);
		$update['endshamsi_month'] = jdate::date("m", strtotime($date), false, true);
		$update['endshamsi_day']   = jdate::date("d", strtotime($date), false, true);
		$update['end_gateway_id']  = $_args['gateway'];
		$update['end_userteam_id'] = $_args['userteam_id'];
		$update['end_time']        = date("Y-m-d H:i:s");

		$updated                         = self::update($update, $start['id']);
		$plan_feature                    = [];
		$plan_feature['type']            = 'exit';
		$plan_feature['updated_record']  = $update;
		$plan_feature['args']            = $_args;
		$plan_feature['start']           = $start;

		\lib\utility\plan::check_feature($plan_feature);

		return $updated;
	}

	/**
	 * get last not exit time of user
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function in_use_time($_args)
	{
		$where = [];

		if(isset($_args['userteam_id']) && is_numeric($_args['userteam_id']))
		{
			$where[] = " hours.userteam_id = $_args[userteam_id] ";
		}

		if(isset($_args['userteam_details']['24h']) && $_args['userteam_details']['24h'])
		{
			// the user has 24h
			// needless to check date of enter
		}
		else
		{
			if(isset($_args['date']) && is_string($_args['date']))
			{
				$where[] = " hours.date = '$_args[date]' ";
			}
		}

		if(!empty($where))
		{
			// $where[] = " hours.end IS NULL ";
			$where = implode(' AND ', $where);
			$query = "SELECT * FROM hours WHERE $where ORDER BY hours.id DESC LIMIT 1";

			$hours_data =  \lib\db::get($query, null, true);
			return $hours_data;
		}
	}


	/**
	 * get the active user in period
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function active_user_period($_args)
	{
		$query =
		"
			SELECT
				SUM(hours.diff)   AS `sum_diff`,
				hours.userteam_id AS `userteam_id`
			FROM
				hours
			INNER JOIN userteams ON userteams.id = hours.userteam_id
			WHERE
				userteams.team_id = $_args[team_id] AND
				hours.start_time  >= '$_args[start]' AND
				hours.end_time    <= '$_args[end]'
			GROUP BY hours.userteam_id
			HAVING sum_diff > $_args[active_time]
		";

		$result = \lib\db::get($query);
		return $result;
	}
}
?>