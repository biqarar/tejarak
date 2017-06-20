<?php
namespace lib\db;
use \lib\db;
use \lib\utility\jdate;
use \lib\debug;
use \lib\utility;

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
	 * Saves an enter.
	 * save enter time of user
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function save_enter($_args)
	{
		$date = date("Y-m-d");

		$userteam_id   = \lib\db\userteams::get_id(
			[
				'team_id' => $_args['team_id'],
				'user_id' => $_args['user_id'],
				'limit'   => 1,
			]
		);

		if(!$userteam_id)
		{
			debug::error(T_("User team not found!"));
			return false;
		}

		$userbranch_id = \lib\db\userbranchs::get_id(
			[
				'team_id'   => $_args['team_id'],
				'branch_id' => $_args['branch_id'],
				'user_id'   => $_args['user_id'],
				'limit'     => 1
			]
		);

		if(!$userbranch_id)
		{
			debug::error(T_("User branch not found!"));
			return false;
		}

		$_args['userbranch_id'] = $userbranch_id;
		$_args['userteam_id']   = $userteam_id;
		$_args['date']          = $date;

		// get last not exit time of this user and this teamd
		$in_use_time = self::in_use_time($_args);

		if($in_use_time)
		{
			debug::error(T_("You was already save your enter time"));
			return false;
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
		$date = date("Y-m-d");

		$userteam_id   = \lib\db\userteams::get_id(
			[
				'team_id' => $_args['team_id'],
				'user_id' => $_args['user_id'],
				'limit'   => 1,
			]
		);

		if(!$userteam_id)
		{
			debug::error(T_("User team not found!"));
			return false;
		}

		$userbranch_id = \lib\db\userbranchs::get_id(
			[
				'team_id'   => $_args['team_id'],
				'branch_id' => $_args['branch_id'],
				'user_id'   => $_args['user_id'],
				'limit'     => 1
			]
		);

		if(!$userbranch_id)
		{
			debug::error(T_("User branch not found!"));
			return false;
		}

		$_args['userbranch_id'] = $userbranch_id;
		$_args['userteam_id']   = $userteam_id;
		$_args['date']          = $date;

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


		$update['end']   = date("H:i");
		$update['diff']  = $diff;
		$update['minus'] = null;
		$update['plus']  = null;

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
		if(isset($_args['team_id']) && is_numeric($_args['team_id']))
		{
			$where[] = " hours.team_id = $_args[team_id] ";
		}

		if(isset($_args['userteam_id']) && is_numeric($_args['userteam_id']))
		{
			$where[] = " hours.userteam_id = $_args[userteam_id] ";
		}

		if(isset($_args['userbranch_id']) && is_numeric($_args['userbranch_id']))
		{
			$where[] = " hours.userbranch_id = $_args[userbranch_id] ";
		}

		if(isset($_args['user_id']) && is_numeric($_args['user_id']))
		{
			$where[] = " hours.user_id = $_args[user_id] ";
		}

		if(isset($_args['date']) && is_string($_args['date']))
		{
			$where[] = " hours.date = '$_args[date]' ";
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