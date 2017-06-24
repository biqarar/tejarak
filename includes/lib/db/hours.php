<?php
namespace lib\db;
use \lib\db;
use \lib\utility\jdate;
use \lib\debug;
use \lib\utility;

class hours
{

	use hours\search;

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

		if($in_use_time)
		{
			debug::error(T_("You was already save your enter time"));
			return false;
		}

		$insert                      = [];
		$insert['user_id']           = $_args['user_id'];
		$insert['team_id']           = $_args['team_id'];
		$insert['start_userteam_id'] = $_args['user_id'];
		$insert['userteam_id']       = $_args['userteam_id'];
		$insert['date']              = date("Y-m-d");
		$insert['year']              = date("Y");
		$insert['month']             = date("m");
		$insert['day']               = date("d");
		$insert['shamsi_date']       = jdate::date("Y-m-d", strtotime($date), false, true);
		$insert['shamsi_year']       = jdate::date("Y", strtotime($date), false, true);
		$insert['shamsi_month']      = jdate::date("m", strtotime($date), false, true);;
		$insert['shamsi_day']        = jdate::date("d", strtotime($date), false, true);;
		$insert['start']             = date("H:i");

		return self::insert($insert);
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

		if(!$start)
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

		$update = [];

		$start_time = $start['date'] . ' '. $start['start'];

		$start_time = strtotime($start_time);
		$end_time   = strtotime(date("Y-m-d H:i:s"));
		$diff       = round(($end_time - $start_time) / 60);


		$update['end']             = date("H:i");
		$update['diff']            = $diff;
		$update['minus']           = null;
		$update['plus']            = null;
		$update['enddate']         = date("Y-m-d");
		$update['endyear']         = date("Y");
		$update['endmonth']        = date("m");
		$update['endday']          = date("d");
		$update['endshamsi_date']  = jdate::date("Y-m-d", strtotime($date), false, true);
		$update['endshamsi_year']  = jdate::date("Y", strtotime($date), false, true);
		$update['endshamsi_month'] = jdate::date("m", strtotime($date), false, true);;
		$update['endshamsi_day']   = jdate::date("d", strtotime($date), false, true);;

		return self::update($update, $start['id']);
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
			$where[] = " hours.end IS NULL ";
			$where = implode(' AND ', $where);
			$query = "SELECT * FROM hours WHERE $where ORDER BY hours.id DESC LIMIT 1";
			return \lib\db::get($query, null, true);
		}
	}
}
?>