<?php
namespace lib\app\report;


trait sum
{

	/**
	 * Gets the report.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The report.
	 */
	public static function report_sum_time()
	{
		if(!\dash\user::id())
		{
			return false;
		}

		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => \dash\app::request(),
			],
		];

		$id = \dash\app::request('id');
		$id = \dash\coding::decode($id);
		if(!$id)
		{
			\dash\db\logs::set('api:report:team:not:found', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Team id not set"), 'team', 'arguments');
			return false;
		}

		if(!$check_is_my_team = \lib\db\teams::access_team_id($id, \dash\user::id(), ['action'=> 'report_sum']))
		{
			\dash\db\logs::set('api:report:team:permission:denide', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Can not access to load detail of this team"), 'team', 'permission');
			return false;
		}

		if(!isset($check_is_my_team['id']))
		{
			\dash\db\logs::set('api:report:team:id:not:found', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Invalid team data"), 'team', 'system');
			return false;
		}

		$year  = \dash\app::request('year');
		$month = \dash\app::request('month');
		$day   = \dash\app::request('day');

		if($year && (!is_numeric($year) || mb_strlen($year) !== 4))
		{
			\dash\db\logs::set('api:report:sum:invalid:year', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Invalid input year"), 'year', 'arguments');
			return false;
		}

		if($month && intval($month) < 10)
		{
			$month = '0'. (string) intval($month);
		}

		if($month && (!is_numeric($month) || mb_strlen($month) !== 2))
		{
			\dash\db\logs::set('api:report:sum:invalid:month', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Invalid input month"), 'month', 'arguments');
			return false;
		}

		if($day && intval($day) < 10)
		{
			$day = '0'. (string) intval($day);
		}

		if($day && (!is_numeric($day) || mb_strlen($day) !== 2))
		{
			\dash\db\logs::set('api:report:sum:invalid:day', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Invalid input day"), 'day', 'arguments');
			return false;
		}

		$date_is_shamsi = false;
		if($year && intval($year) > 1300 && intval($year) < 1600)
		{
			$date_is_shamsi = true;
		}

		$user = \dash\app::request('user');
		$user = \dash\coding::decode($user);
		if($user)
		{
			$check_user_in_team = \lib\db\userteams::get(['team_id' => $id, 'user_id' => $user, 'limit' => 1, 'rule'=> ['IN', '("user", "admin")']]);

			if(!$check_is_my_team || !isset($check_is_my_team['userteam_id']))
			{
				\dash\db\logs::set('api:report:sum:user:is:not:in:team', \dash\user::id(), $log_meta);
				\dash\notif::error(T_("This user is not in this team"), 'user', 'arguments');
				return false;
			}
		}
		else
		{
			$user = null;
		}

		$meta                   = [];
		$meta['team_id']        = $id;
		$meta['user_id']        = $user;
		$meta['userteam_id']    = $check_is_my_team['userteam_id'];
		$meta['year']           = $year;
		$meta['month']          = $month;
		$meta['day']            = $day;
		$meta['date_is_shamsi'] = $date_is_shamsi;
		$meta['export']  	    = \dash\app::request('export');
		$result                 = \lib\db\hours::sum_time($meta);

		$temp = [];
		foreach ($result as $key => $value)
		{
			$check = self::ready_sum_report($value);
			if($check)
			{
				$temp[] = $check;
			}
		}
		if(\dash\app::request('export'))
		{
			\dash\utility\export::csv(['data' => $temp, 'name' => T_("tejarak-sum-report")]);
		}
		else
		{
			return $temp;
		}
	}


	/**
	 * ready data to show in api
	 * remove some field
	 * change type of data
	 *
	 *
	 * @param      <type>  $_data  The data
	 *
	 * @return     array   ( description_of_the_return_value )
	 */
	public static function ready_sum_report($_data)
	{
		$temp = [];
		foreach ($_data as $key => $value)
		{
			switch ($key)
			{
				default:
					$temp[$key] = $value;
					break;
			}
		}
		krsort($temp);
		return $temp;
	}

}
?>