<?php
namespace lib\app\report;


trait period
{

	/**
	 * Gets the report.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The report.
	 */
	public static function report_period_time()
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
			\dash\db\logs::set('api:report:period:team:not:found', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Team id not set"), 'team', 'arguments');
			return false;
		}

		$user_id = null;
		$user    = \dash\app::request('user');

		if($user)
		{
			$user_id = \dash\coding::decode($user);
			if(!$user_id)
			{
				\dash\db\logs::set('api:report:period:user:id:set:but:is:not:valid', \dash\user::id(), $log_meta);
				\dash\notif::error(T_("Invalid user id"), 'user', 'arguments');
				return false;
			}
		}

		$check_is_my_team = null;
		if($user_id)
		{
			if($check_is_my_team = \lib\db\teams::access_team_id($id, \dash\user::id(), ['action'=> 'report_period_all']))
			{
				if(!$check_is_my_team = \lib\db\teams::access_team_id($id, $user_id, ['action'=> 'report_u']))
				{
					\dash\db\logs::set('api:report:period:user:is:not:in:team', \dash\user::id(), $log_meta);
					\dash\notif::error(T_("This user is not in this team"), 'user', 'arguments');
					return false;
				}
			}
			else
			{
				\dash\db\logs::set('api:report:period:user:access:load:report', \dash\user::id(), $log_meta);
				\dash\notif::error(T_("No access to load this report"), 'user', 'arguments');
				return false;
			}
		}
		else
		{
			if($check_is_my_team = \lib\db\teams::access_team_id($id, \dash\user::id(), ['action'=> 'report_month_all']))
			{
				$user_id = null;
				// no user was set but the user is admin of this team
				// can see all user time in year
			}
			elseif($check_is_my_team = \lib\db\teams::access_team_id($id, \dash\user::id(), ['action'=> 'report_u']))
			{
				// no user was set
				// and this user is user of this team
				// can see just her time
				$user_id = \dash\user::id();
			}
			else
			{
				\dash\db\logs::set('api:report:team:permission:denide', \dash\user::id(), $log_meta);
				\dash\notif::error(T_("Can not access to load detail of this team"), 'team', 'permission');
				return false;
			}
		}

		if(!isset($check_is_my_team['id']))
		{
			\dash\db\logs::set('api:report:period:team:id:not:found', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Invalid team data"), 'team', 'system');
			return false;
		}


		$start = \dash\app::request('start');

		if($start)
		{
			if(($date_start = \DateTime::createFromFormat('Y-m-d', $start)) === false)
			{
			 	\dash\db\logs::set('api:report:period:start:invalid', \dash\user::id(), $log_meta);
				\dash\notif::error(T_("Invalid start date"), 'start', 'arguments');
				return false;
			}
		}
		else
		{
			return false;
		}

		$end   = \dash\app::request('end');
		if($end)
		{
			if(\DateTime::createFromFormat('Y-m-d', $end) === false)
			{
			 	\dash\db\logs::set('api:report:period:end:invalid', \dash\user::id(), $log_meta);
				\dash\notif::error(T_("Invalid end date"), 'end', 'arguments');
				return false;
			}
		}
		else
		{
			return false;
		}

		$start_year = (new \DateTime($start))->format("Y");
		$end_year   = (new \DateTime($end))->format("Y");

		$start_date_is_shamsi = false;
		if($start_year && intval($start_year) > 1300 && intval($start_year) < 1600)
		{
			$start_date_is_shamsi = true;
		}

		$end_date_is_shamsi = false;
		if($end_year && intval($end_year) > 1300 && intval($end_year) < 1600)
		{
			$end_date_is_shamsi = true;
		}

		if($start_date_is_shamsi === $end_date_is_shamsi)
		{
			$date_is_shamsi = $start_date_is_shamsi;
		}
		else
		{
			\dash\db\logs::set('api:report:period:start:end:date:shamsi:not:mathc', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Start date and end date is not match"), null, 'arguments');
			return false;
		}

		$meta                   = [];
		$meta['team_id']        = $check_is_my_team['id'];
		$meta['start']          = $start;
		$meta['end']            = $end;
		$meta['order']          = 'DESC';
		$meta['user_id']        = $user_id;
		$meta['userteam_id']    = $check_is_my_team['userteam_id'];
		$meta['date_is_shamsi'] = $date_is_shamsi;
		$meta['export']	        = \dash\app::request('export');
		$result                 = \lib\db\hours::sum_period_time($meta);

		$temp = [];
		foreach ($result as $key => $value)
		{
			$check = self::ready_month_report($value);
			if($check)
			{
				$temp[] = $check;
			}
		}

		if(\dash\app::request('export'))
		{
			\dash\utility\export::csv(['data' => $temp, 'name' => T_("tejarak-period-report")]);
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
	public static function ready_period_report($_data)
	{
		$temp = [];
		foreach ($_data as $key => $value)
		{
			switch ($key)
			{
				case 'userteam_id':
					continue;
					break;
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