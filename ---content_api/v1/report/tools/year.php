<?php
namespace content_api\v1\report\tools;


trait year
{

	/**
	 * Gets the report.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The report.
	 */
	public function report_year_time()
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
				'input' => \dash\utility::request(),
			],
		];

		$id = \dash\utility::request('id');
		$id = \dash\coding::decode($id);
		if(!$id)
		{
			\dash\db\logs::set('api:report:team:not:found', $this->user_id, $log_meta);
			\dash\notif::error(T_("Team id not set"), 'team', 'arguments');
			return false;
		}

		$user = \dash\utility::request('user');
		$user = \dash\coding::decode($user);
		if($user)
		{
			if(!$check_is_my_team = \lib\db\teams::access_team_id($id, $user, ['action'=> 'report_u']))
			{
				\dash\db\logs::set('api:report:sum:user:is:not:in:team', $this->user_id, $log_meta);
				\dash\notif::error(T_("This user is not in this team"), 'user', 'arguments');
				return false;
			}
		}
		else
		{
			if($check_is_my_team = \lib\db\teams::access_team_id($id, $this->user_id, ['action'=> 'report_sum']))
			{
				$user = null;
				// no user was set but the user is admin of this team
				// can see all user time in year
			}
			elseif($check_is_my_team = \lib\db\teams::access_team_id($id, $this->user_id, ['action'=> 'report_u']))
			{
				// no user was set
				// and this user is user of this team
				// can see just her time
				$user = $this->user_id;
			}
			else
			{
				\dash\db\logs::set('api:report:team:permission:denide', $this->user_id, $log_meta);
				\dash\notif::error(T_("Can not access to load detail of this team"), 'team', 'permission');
				return false;
			}
		}

		if(!isset($check_is_my_team['id']))
		{
			\dash\db\logs::set('api:report:team:id:not:found', $this->user_id, $log_meta);
			\dash\notif::error(T_("Invalid team data"), 'team', 'system');
			return false;
		}

		$year  = \dash\utility::request('year');

		if($year && (!is_numeric($year) || mb_strlen($year) !== 4))
		{
			\dash\db\logs::set('api:report:sum:invalid:year', $this->user_id, $log_meta);
			\dash\notif::error(T_("Invalid input year"), 'year', 'arguments');
			return false;
		}

		$date_is_shamsi = false;
		if($year)
		{
			if(intval($year) > 1300 && intval($year) < 1600)
			{
				$date_is_shamsi = true;
			}
		}
		else
		{
			if(\dash\language::current() === 'fa')
			{
				$date_is_shamsi = true;
			}
		}

		$meta                   = [];
		$meta['team_id']        = $id;
		$meta['user_id']        = $user;
		$meta['userteam_id']    = $check_is_my_team['userteam_id'];
		$meta['year']           = $year;
		$meta['date_is_shamsi'] = $date_is_shamsi;
		$meta['export']         = \dash\utility::request('export');
		$result                 = \lib\db\hours::sum_time($meta);
		$temp                   = [];

		foreach ($result as $key => $value)
		{
			$check = $this->ready_year_report($value);
			if($check)
			{
				$temp[] = $check;
			}
		}

		if (\dash\utility::request('export'))
		{
			\dash\utility\export::csv(['data' => $temp, 'name' => T_("tejarak-year-report")]);
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
	public function ready_year_report($_data)
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