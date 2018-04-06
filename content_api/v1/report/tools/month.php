<?php
namespace content_api\v1\report\tools;


trait month
{

	/**
	 * Gets the report.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The report.
	 */
	public function report_month_time()
	{
		if(!$this->user_id)
		{
			return false;
		}

		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => \lib\utility::request(),
			],
		];

		$id = \lib\utility::request('id');
		$id = \dash\coding::decode($id);

		if(!$id)
		{
			\dash\db\logs::set('api:report:month:team:not:found', $this->user_id, $log_meta);
			\lib\notif::error(T_("Team id not set"), 'team', 'arguments');
			return false;
		}

		$user_id = null;
		$user    = \lib\utility::request('user');

		if($user)
		{
			$user_id = \dash\coding::decode($user);
			if(!$user_id)
			{
				\dash\db\logs::set('api:report:month:user:id:set:but:is:not:valid', $this->user_id, $log_meta);
				\lib\notif::error(T_("Invalid user id"), 'user', 'arguments');
				return false;
			}
		}

		$check_is_my_team = null;
		if($user_id)
		{
			if($check_is_my_team = \lib\db\teams::access_team_id($id, $this->user_id, ['action'=> 'report_month_all']))
			{
				if(!$check_is_my_team = \lib\db\teams::access_team_id($id, $user_id, ['action'=> 'report_u']))
				{
					\dash\db\logs::set('api:report:month:user:is:not:in:team', $this->user_id, $log_meta);
					\lib\notif::error(T_("This user is not in this team"), 'user', 'arguments');
					return false;
				}
			}
			else
			{
				\dash\db\logs::set('api:report:month:user:access:load:report', $this->user_id, $log_meta);
				\lib\notif::error(T_("No access to load this report"), 'user', 'arguments');
				return false;
			}
		}
		else
		{
			if($check_is_my_team = \lib\db\teams::access_team_id($id, $this->user_id, ['action'=> 'report_month_all']))
			{
				$user_id = null;
				// no user was set but the user is admin of this team
				// can see all user time in year
			}
			elseif($check_is_my_team = \lib\db\teams::access_team_id($id, $this->user_id, ['action'=> 'report_u']))
			{
				// no user was set
				// and this user is user of this team
				// can see just her time
				$user_id = $this->user_id;
			}
			else
			{
				\dash\db\logs::set('api:report:team:permission:denide', $this->user_id, $log_meta);
				\lib\notif::error(T_("Can not access to load detail of this team"), 'team', 'permission');
				return false;
			}
		}

		if(!isset($check_is_my_team['id']))
		{
			\dash\db\logs::set('api:report:month:team:id:not:found', $this->user_id, $log_meta);
			\lib\notif::error(T_("Invalid team data"), 'team', 'system');
			return false;
		}

		$year  = \lib\utility::request('year');
		$month = \lib\utility::request('month');

		if($year)
		{
			if(!is_numeric($year) || mb_strlen($year) !== 4)
			{
				\dash\db\logs::set('api:report:month:invalid:year', $this->user_id, $log_meta);
				\lib\notif::error(T_("Invalid input year"), 'year', 'arguments');
				return false;
			}
		}
		else
		{
			if(\lib\language::current() === 'fa')
			{
				$year = \dash\utility\jdate::date("Y", false, false);
			}
			else
			{
				$year = date("Y");
			}
		}

		if($month && intval($month) < 10)
		{
			$month = '0'. (string) intval($month);
		}

		if($month && (!is_numeric($month) || mb_strlen($month) !== 2))
		{
			\dash\db\logs::set('api:report:month:invalid:month', $this->user_id, $log_meta);
			\lib\notif::error(T_("Invalid input month"), 'month', 'arguments');
			return false;
		}

		$date_is_shamsi = false;
		if($year && intval($year) > 1300 && intval($year) < 1600)
		{
			$date_is_shamsi = true;
		}

		$meta                   = [];
		$meta['team_id']        = $check_is_my_team['id'];
		$meta['year']           = $year;
		$meta['month']          = $month;
		$meta['order']          = 'DESC';
		$meta['user_id']        = $user_id;
		$meta['userteam_id']    = $check_is_my_team['userteam_id'];
		$meta['date_is_shamsi'] = $date_is_shamsi;
		$meta['export']	        = \lib\utility::request('export');

		$result  = \lib\db\hours::sum_month_time($meta);

		$temp = [];
		foreach ($result as $key => $value)
		{
			$check = $this->ready_month_report($value);
			if($check)
			{
				$temp[] = $check;
			}
		}

		if(\lib\utility::request('export'))
		{
			\dash\utility\export::csv(['data' => $temp, 'name' => T_('tejarak-month-report')]);
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
	public function ready_month_report($_data)
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