<?php
namespace lib\db;
use \lib\db;
use \lib\utility\jdate;
class hours
{

	// CREATE TABLE `hours` (
	//   `id`					int(10) UNSIGNED NOT NULL,
	//   `user_id`				int(10) UNSIGNED NOT NULL,
	//   `team_id`				int(10) UNSIGNED NOT NULL,
	//   `userteam_id`			int(10) UNSIGNED NOT NULL,
	//   `userbranch_id`		int(10) UNSIGNED NOT NULL,
	//   `start_getway_id`		int(10) UNSIGNED NOT NULL,
	//   `end_getway_id`		int(10) UNSIGNED DEFAULT NULL,
	//   `start_userbranch_id`	int(10) UNSIGNED NOT NULL,
	//   `end_userbranch_id`	int(10) UNSIGNED DEFAULT NULL,
	//   `date`					date NOT NULL,
	//   `year`					int(4) UNSIGNED NOT NULL,
	//   `month`				int(2) UNSIGNED NOT NULL,
	//   `day`					int(2) UNSIGNED NOT NULL,
	//   `shamsi_date`			date NOT NULL,
	//   `shamsi_year`			int(4) UNSIGNED NOT NULL,
	//   `shamsi_month`			int(2) UNSIGNED NOT NULL,
	//   `shamsi_day`			int(2) UNSIGNED NOT NULL,
	//   `start`				time NOT NULL,
	//   `end`					time DEFAULT NULL,
	//   `diff`					int(10) UNSIGNED DEFAULT NULL,
	//   `minus`				int(10) UNSIGNED DEFAULT NULL,
	//   `plus`					int(10) UNSIGNED DEFAULT NULL,
	//   `type`					enum('nothing','base','wplus','wminus','all') DEFAULT 'all',
	//   `accepted`				int(10) UNSIGNED DEFAULT NULL,
	//   `createdate`			datetime DEFAULT CURRENT_TIMESTAMP,
	//   `date_modified`		timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
	//   `status`				enum('active','awaiting','deactive','removed','filter') DEFAULT 'awaiting'
	// ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


	/**
	 * insert new record in hours table
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert($_args)
	{
		$set = \lib\db\config::make_set($_args);
		$query = "INSERT INTO hours SET $set ";
		return \lib\db::query($query);
	}


	public static function save($_args)
	{
		// date of now
		$date = date("Y-m-d");
		// start or end of time
		$type = isset($_args['type']) ? $_args['type'] : null;

		switch ($type)
		{
			// save enter time
			case 'enter':
				return self::save_enter($_args);
				break;
			// save exit time
			case 'exit':
				return self::save_exit($_args);
				break;
			// error return false
			default:
				return false;
				break;
		}
	}

	/**
	 * get
	 *
	 * @param      <type>  $_where  The where
	 */
	public static function get()
	{
		return \lib\db\config::public_get('hours', ...func_get_args());
	}


	/**
	 * update
	 *
	 * @param      <type>  $_where  The where
	 */
	public static function update()
	{
		return \lib\db\config::public_update('hours', ...func_get_args());
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

		$userteam_id   = \lib\db\userteams::get_id(['team_id' => $_args['team_id'], 'user_id' => $_args['user_id']]);
		$userbranch_id = \lib\db\userbranchs::get_id(['branch_id' => $_args['branch_id'], 'user_id' => $_args['user_id']]);

		if(self::get(['user_id' => $_args['user_id'], 'date' => date("Y-m-d")]))
		{
			\lib\debug::error(T_("You was already save your enter time"));
			return ;
		}

		$insert                        = [];
		$insert['user_id']             = $_args['user_id'];
		$insert['team_id']             = $_args['team_id'];
		$insert['userteam_id']         = $userbranch_id;
		$insert['userbranch_id']       = $userteam_id;
		$insert['start_userbranch_id'] = $_args['branch_id'];
		$insert['date']                = date("Y-m-d");
		$insert['year']                = date("Y");
		$insert['month']               = date("m");
		$insert['day']                 = date("d");
		$insert['shamsi_date']         = jdate::date("Y-m-d", strtotime($date), false, true);
		$insert['shamsi_year']         = jdate::date("Y", strtotime($date), false, true);
		$insert['shamsi_month']        = jdate::date("m", strtotime($date), false, true);;
		$insert['shamsi_day']          = jdate::date("d", strtotime($date), false, true);;
		$insert['start']               = date("H:i");

		return self::insert($insert);
	}

	/**
	 * save exit time of user
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function save_exit($_args)
	{
		if($start = self::get(['user_id' => $_args['user_id'], 'date' => date("Y-m-d"), 'limit' => 1]))
		{
		}
		else
		{
			\lib\debug::error(T_("You was not save your enter time"));
			return ;
		}

		$check = true;

		if(!isset($start['start'])) $check = false;
		if(!isset($start['date'])) $check = false;
		if(!isset($start['id'])) $check = false;

		if(!$check)
		{
			\lib\debug::error(T_("Invalid data"));
			return false;
		}

		$update = [];

		$start_time = $start['date'] . ' '. $start['start'];

		$start_time = strtotime($start_time);
		$end_time   = strtotime(date("Y-m-d H:i:s"));
		$diff       = round(($end_time - $start_time) / 60);


		$update['end']   = date("H:i");
		$update['diff']  = $diff;
		$update['minus'] = null;
		$update['plus']  = null;

		return self::update($update, $start['id']);
	}






















	/**
	 * update hours record by id
	 * get record id and status and end time
	 *
	 * @param      <type>   $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function update_old($_args)
	{

		if(!isset($_args['id']))
		{
			\lib\debug::error(T_("record id not found"));
			$id = 0;
		}
		else
		{
			$id = $_args['id'];
		}


		if(isset($_args['status']))
		{
			$status = " hours.status = '" . $_args['status'] . "' ";
		}
		else
		{
			$status = "";
		}

		if(isset($_args['time']))
		{

			$qry =
			"	SELECT
					start,
					end,
					status
				FROM
					hours
				WHERE id = $id
				LIMIT 1
			";
			$check = db::get($qry,null, true);
			if(!$check)
			{
				return false;
			}
			else
			{
				$time = $_args['time'];
				$saved_time = $check['start'];
				if($saved_time > $time)
				{
					$temp       = $time;
					$time       = "'$saved_time'";
					$saved_time = "'$temp'";
				}
				else
				{
					$saved_time = "start";
					$time       = "end";
				}
				$time_query =
				"
						start = $saved_time,
						end   = $time
				";
			}
		}
		else
		{
			$time_query = "";
		}

		if($status && $time_query)
		{
			$time_query = $time_query . ",";
		}

		if(!$status && !$time_query)
		{
			return false;
		}

		$query =
		"
			UPDATE
				hours
			SET
				$time_query
				$status
			WHERE
				id = $id
		";
		return db::query($query);
	}


	/**
	 * get hours.id and hours.status and update hours status
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function change_hours_status($_args)
	{
		if(isset($_args['id']))
		{
			$id = $_args['id'];
		}
		else
		{
			$id = 0;
		}

		if(isset($_args['type']))
		{
			$type = $_args['type'];
		}
		else
		{
			$type = "";
		}

		$saved_type =
		"
			SELECT
				hours.type AS 'type'
			FROM
				hours
			WHERE
				hours.id = $id
			LIMIT 1
		";
		$saved_type = \lib\db::get($saved_type, 'type', true);

		$new_type = "";

		switch ($type)
		{
			case 'diff':
				switch ($saved_type)
				{
					case 'all':
					case 'wplus':
					case 'wminus':
					case 'base':
						$new_type = "nothing";
						break;

					case 'nothing':
						$new_type = "base";
						break;

					default:
						$new_type = "base";
						break;
				}
				break;

			case 'minus':
				switch ($saved_type)
				{
					case 'all':
						$new_type = "wplus";
						break;

					case 'nothing':
					case 'base':
						$new_type = "wminus";
						break;

					case 'wplus':
						$new_type = "all";
						break;

					case 'wminus':
						$new_type = "nothing";
						break;

					default:
						$new_type = "nothing";
						break;
				}
				break;

			case 'plus':
				switch ($saved_type)
				{
					case 'all':
						$new_type = "wminus";
						break;

					case 'nothing':
					case 'base':
						$new_type = "wplus";
						break;

					case 'wplus':
						$new_type = "base";
						break;

					case 'wminus':
						$new_type = "all";
						break;

					default:
						$new_type = "nothing";
						break;
				}
				break;
			case 'accept':
				$new_type = "all";
				break;
			default:
				$new_type = "nothing";
				break;
		}

		$update_type =
		"
			UPDATE
				hours
			SET
				hours.type = '$new_type'
			WHERE
				hours.id = $id
		";

		$result = \lib\db::query($update_type);

		if($result)
		{
			return $new_type;
		}
		else
		{
			return false;
		}
	}


	/**
	 * return last record of hours table
	 * if none param send to this function get last record of all users
	 * you can send ['user' => \d+] to get last record of this users
	 * @param      array   $_args  The arguments
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	private static function get_last_time($_args = [])
	{
		if(isset($_args['user_id']))
		{
			$user = " users.id = '" . $_args['user_id'] . "' ";
			$user_displayname = "";
		}
		else
		{
			$user = "";
			$user_displayname = "users.user_displayname 	as 'name',";
		}

		if(isset($_args['date']))
		{
			$date = " hours.date = '". $_args['date']. "'";
		}
		else
		{
			$date = "";
		}


		if($date || $user)
		{
			$where = " WHERE ";
		}
		else
		{
			$where = "";
		}

		if($date && $user)
		{
			$user = " AND " . $user;
		}
		$field =
		"
			hours.id 						AS 'id',
			hours.date 				AS 'date',
			$user_displayname
			hours.start 				AS 'start',
			hours.end 					AS 'end',
			hours.end 					AS 'end',
			IFNULL(hours.diff,0) 	 	AS 'diff',
			IFNULL(hours.plus,0) 	 	AS 'plus',
			IFNULL(hours.minus,0) 	 	AS 'minus',
			hours.status				AS 'status',
			hours.type					AS 'type',
			IFNULL(hours.accepted,0) 	AS 'accepted'
		";
		// pagnation
		$count_record =
		"
			SELECT
				$field
			FROM
				hours
				LEFT JOIN users on hours.user_id = users.id

				$where
				$date
				$user
		";

		if(isset($_args['export']) && $_args['export'])
		{
			$limit = "";
		}
		else
		{
			list($limit_start, $length) = \lib\db::pagnation($count_record, 10);
			$limit = " LIMIT $limit_start, $length ";
		}

		//--------- repeat to every query
		$query = "
				SELECT
					$field
				FROM
					hours
				LEFT JOIN users on hours.user_id = users.id
				$where
				$date
				$user
				ORDER BY
					hours.date DESC, hours.end ASC
				$limit
				";
		$report = db::get($query);
		return $report;
	}


	/**
	 * get sum of hours table
	 * total hour of work in month, week, day
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function sum($_args)
	{
		$user  = isset($_args['user'])  ? $_args['user']  : null;
		$day   = isset($_args['day'])   ? $_args['day']   : null;
		$week  = isset($_args['week'])  ? $_args['week']  : null;
		$month = isset($_args['month']) ? $_args['month'] : null;
		$year  = isset($_args['year'])  ? $_args['year']  : null;
		$lang  = isset($_args['lang'])  ? $_args['lang']  : null;

		if($month == '0')
		{
			$month = null;
		}

		$q         = [];
		$q['user'] = $user != null ? "users.id = $user" : null;

		if($user)
		{
			$USER = "";
		}
		else
		{
			$USER = " GROUP BY hours.user_id ";
		}

		if($lang == "fa")
		{
			if($year && $month)
			{
				list($start_date, $end_date)  = \lib\utility\jdate::jalali_month($year, $month);
				$q['month'] = " hours.date > '$start_date' AND hours.date < '$end_date' ";

			}
			elseif($year && !$month)
			{
				list($start_date, $end_date)  = \lib\utility\jdate::jalali_year($year);
				$q['month'] = " hours.date > '$start_date' AND hours.date < '$end_date' ";
			}
		}
		else
		{
			$q['month'] = $month  != null ? "YEAR(hours.date) = '$year' AND MONTH(hours.date) = '$month' " : null;
			$q['year']  = $year   != null ? "YEAR(hours.date) = '$year' " : null;
			$q['week']  = $week   != null ? "WEEKOFYEAR(hours.date)=WEEKOFYEAR('$week')" : null;
		}

		$condition = ' AND '. implode(" AND ", array_filter($q));

		$start  = (isset($_args["start"])) ? $_args["start"] : 0; // start limit
		$end    = (isset($_args["end"]))   ? $_args["end"]   : 10; // end limit

		//--------- repeat to every query
		$no_position = T_("Undefined");

		$query = "
				SELECT
					users.id as id,
					users.user_displayname as name,
					TRIM(BOTH '".'"'."' FROM IFNULL(users.user_meta, '$no_position')) as meta,
					sum(hours.diff) as diff,
					sum(hours.plus) as plus,
					sum(hours.minus) as minus,
					sum(hours.accepted) as accepted
				FROM
					hours
				INNER JOIN users on hours.user_id = users.id
				WHERE
					  (hours.status = 'filter' OR hours.status = 'active')
				$condition
				$USER
				LIMIT $start,$end
				";
		$report = db::get($query);
		return $report;
	}


	/**
	 * status of users
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get_old($_args)
	{
		$year    = $_args['year'];
		$month   = $_args['month'];
		$day     = $_args['day'];
		$user_id = $_args['user_id'];
		$lang    = $_args['lang'];
		$export  = $_args['export'];
		$type    = $_args['type'] ? $_args['type'] : 'detail';
		// add order if exist
		$order   = $_args['order'];
		$order   = str_replace('_', ' ', $order);
		if($order)
		{
			$order = "ORDER BY ". $order;
		}
		else
		{
			$order = null;
		}

		// check user id . if users id is set get add data by this users id and if users id is not set get all users
		if($user_id == null)
		{
			$user_id_query = "";
		}
		else
		{
			$user_id_query = " AND user_id = $user_id ";
		}

		// set year = false to use in IF syntax
		if($year == '0000')
		{
			$year = false;
		}

		if($month == '00')
		{
			$month = false;
		}

		if($day == '00')
		{
			$day = false;
		}

		// other mode that need to change to new mode
		if(!$year && $month && $day)
		{
			$year = date("Y");
		}

		if(!$year && !$month && $day)
		{
			$year  = date("Y");
			$month = date("m");
		}

		if(!$year && $month && !$day)
		{
			$year = date("Y");
		}

		if($year && !$month && $day)
		{
			$month = date("m");
		}

		if(!$year && !$month && !$day && !$user_id)
		{
			return self::get_last_time(['export' => $export]);
		}

		if(!$year && !$month && !$day && $user_id)
		{
			return self::get_last_time(['user_id' => $user_id, 'export' => $export]);
		}

		if($year && $month && $day)
		{
			if($lang == 'fa')
			{
				$jdate = \lib\utility\jdate::toGregorian($year,$month, $day);
				$jdate = join($jdate, "-");
				$date = $jdate;
			}
			else
			{
				$date = "$year-$month-$day";
			}

			if($user_id)
			{
				return self::get_last_time(['user_id' => $user_id, 'date' => $date, 'export' => $export]);
			}
			else
			{
				return self::get_last_time(['date' => $date, 'export' => $export]);
			}
		}

		// fields of table whit sum function
		$sum_fields =
		"
			SUM(IFNULL(hours.diff,0))		AS 'diff',
			SUM(IFNULL(hours.plus,0))		AS 'plus',
			SUM(IFNULL(hours.minus,0))		AS 'minus',
			SUM(IFNULL(hours.accepted,0))	AS 'accepted'
		";
		$field =
		"
			count(hours.date) 				as 'count',
			$sum_fields
		";

		// like this : 1395-01-00
		if($year && $month && !$day)
		{
			// get daily count of hours
			if($lang == 'fa')
			{
				$day_query = "(CASE ";
				for ($i=1; $i <= 31 ; $i++)
				{
					if($i < 10){
						$i = "0". $i;
					}
					$jdate = \lib\utility\jdate::toGregorian($year,$month, $i);
					$jdate = join($jdate, "-");
					$day_query .=	" WHEN hours.date = '{$jdate}' THEN '$i' \n";
				}
				list($start_date, $end_date) = \lib\utility\jdate::jalali_month($year, $month);
				$where = " hours.date >= '$start_date' AND hours.date <= '$end_date' ";
				$group = " GROUP BY users.user_displayname, day";
				$field =
				"
			 		$day_query END) 		AS 'day',
			 		COUNT(hours.date)	AS 'count',
					$sum_fields
				";
			}
			else
			{
				$where = " hours.date LIKE '$year-$month%'	";
				$group = " GROUP BY hours.user_id, DAY(hours.date)";
				$field =
				"
					DAY(hours.date)	AS 'day',
			 		COUNT(hours.id)			AS 'count',
					$sum_fields
				";
			}

			if(!$user_id)
			{
				$field =" users.user_displayname	AS 'name', " . $field;
				$group .= ", users.user_displayname ";
			}
		}

		if($year && !$month && !$day)
		{
			$field =
			"
				'$year' 							AS 'year',
				hours.user_id,
		 		COUNT(DATE(hours.date)) 		AS 'count',
				SUM(hours.diff)	 			AS 'diff',
				SUM(IFNULL(hours.plus,0))		AS 'plus',
				SUM(IFNULL(hours.minus,0))		AS 'minus',
				SUM(hours.accepted)	 		AS 'accepted'
			";
			if($lang == 'fa')
			{
				$month_query = "(CASE ";
				for ($i=1; $i <= 12 ; $i++)
				{
					if($i < 10){
						$i = "0". $i;
					}
					$jdate = \lib\utility\jdate::jalali_month($year, $i);
					$month_name = \lib\utility\jdate::date("m", $jdate[0],false);
					$month_query .=	" WHEN hours.date >= '{$jdate[0]}' AND hours.date <= '{$jdate[1]}' THEN '$month_name' \n";
				}
				list($start_date, $end_date) = \lib\utility\jdate::jalali_year($year);
				$where = " hours.date >= '$start_date' AND hours.date <= '$end_date' ";
				$group = " GROUP BY hours.user_id, month ";
				$field = "	$month_query  END) 					AS 'month'," . $field;
			}
			else
			{
				$where = " hours.date LIKE '$year%' ";
				$group = " GROUP BY hours.user_id, MONTH(hours.date)";
			}

			if(!$user_id)
			{
				$field =" users.user_displayname	AS 'name', " . $field;
				$group .= ", users.user_displayname ";
			}
		}
		if(!$export)
		{
			// pagnation
			$count_record =
			"
				SELECT
					SQL_CALC_FOUND_ROWS
					$field
				FROM
					hours
				INNER JOIN users on hours.user_id = users.id
				WHERE
				$where
				$user_id_query
				$group
				$order
			";
			// MYSQL GET TOTAL RECORD WHITOUT LIMIT
			// SELECT SQL_CALC_FOUND_ROWS * FROM TABLE WHERE GROUP ORDER LIMIT
			// SELECT FOUND_ROWS();
			list($limit_start, $length) = \lib\db::pagnation($count_record, 10);
			$limit = " LIMIT $limit_start, $length ";
		}
		else
		{
			$limit = "";
		}

		$query =
		"	SELECT
				$field
			FROM
				hours
			INNER JOIN users on hours.user_id = users.id
			WHERE
				$where
				$user_id_query
				$group
				$order
				$limit
		";
		// var_dump($query);
		// exit();
		$result = \lib\db::get($query);
		return $result;
	}


	/**
	 * [summary description]
	 * @return [type] [description]
	 */
	public static function summary($_args = [])
	{
		$user_id = null;
		if(isset($_args['user_id']))
		{
			$user_id = " AND users.id = $_args[user_id] ";
		}

		$today  = date("Y-m-d");
		$report = [];

		//--------- repeat to every query
		$field = "users.id,users.user_displayname as displayname,
				 SUM(IFNULL(hours.accepted,0))   	as 'accepted',
				 SUM(IFNULL(hours.diff,0)) 		as 'diff',
				 SUM(IFNULL(hours.plus,0)) 	 	as 'plus',
				 SUM(IFNULL(hours.minus,0)) 	 	as 'minus'
				";

		$join =	"FROM hours
				  INNER JOIN users on hours.user_id = users.id
				  WHERE
				  (hours.status = 'filter' OR hours.status = 'active') ";

		$qry = "SELECT $field,
			'daily' as type
			$join
			AND hours.date = '$today'
			$user_id
			GROUP BY
				hours.user_id,
				hours.date
		";

		if(\lib\define::get_language() === 'fa')
		{
			$jalali_month = \lib\utility\jdate::date("m",false, false);
			$jalali_year  = \lib\utility\jdate::date("Y",false, false);

			list($start_date, $end_date) = \lib\utility\jdate::jalali_month($jalali_year, $jalali_month);

			$start_week = date("Y-m-d", strtotime("last Saturday", time()));
			$end_week   = date("Y-m-d", strtotime("Saturday", time()));

			$qry .= "
			UNION
				SELECT $field,
				'week' as type
				$join
				AND (hours.date >= '$start_week' AND hours.date < '$end_week')
				GROUP BY hours.user_id
			UNION
			SELECT $field,
			'month' as type
			$join
			AND (hours.date >= '$start_date' AND hours.date < '$end_date')
			GROUP BY hours.user_id";

		}
		else
		{
			$qry .= "
			UNION
				SELECT $field,
				'week' as type
				$join
				AND WEEKOFYEAR(hours.date)=WEEKOFYEAR(NOW())
				GROUP BY hours.user_id
			UNION
				SELECT $field,
				'month' as type
				$join
				AND YEAR(hours.date) = YEAR(NOW()) AND MONTH(hours.date)=MONTH(NOW())
				GROUP BY hours.user_id";
		}

		$report = db::get($qry);
		$return = array();
		foreach ($report as $key => $value)
		{
			$id = $value['id'];
			if(!isset($return[$id]))
			{
				$return[$id]         = [];
				$return[$id]['id']   = $id;
				$return[$id]['name'] = $value['displayname'];
			}

			$return[$id][$value['type']]['diff']  = $value['diff'];
			$return[$id][$value['type']]['plus']  = $value['plus'];
			$return[$id][$value['type']]['minus'] = $value['minus'];
			$return[$id][$value['type']]['total'] = $value['accepted'];
		}
		return $return;
	}
}
?>