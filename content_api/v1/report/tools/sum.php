<?php
namespace content_api\v1\report\tools;


trait sum
{

	/**
	 * Gets the report.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The report.
	 */
	public function report_sum_time()
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
		$id = \lib\utility\shortURL::decode($id);
		if(!$id)
		{
			\lib\db\logs::set('api:report:team:not:found', $this->user_id, $log_meta);
			\lib\debug::error(T_("Team id not set"), 'team', 'arguments');
			return false;
		}

		if(!$check_is_my_team = \lib\db\teams::access_team_id($id, $this->user_id, ['action'=> 'report_sum']))
		{
			\lib\db\logs::set('api:report:team:permission:denide', $this->user_id, $log_meta);
			\lib\debug::error(T_("Can not access to load detail of this team"), 'team', 'permission');
			return false;
		}

		if(!isset($check_is_my_team['id']))
		{
			\lib\db\logs::set('api:report:team:id:not:found', $this->user_id, $log_meta);
			\lib\debug::error(T_("Invalid team data"), 'team', 'system');
			return false;
		}

		$year  = \lib\utility::request('year');
		$month = \lib\utility::request('month');
		$day   = \lib\utility::request('day');

		if($year && (!is_numeric($year) || mb_strlen($year) !== 4))
		{
			\lib\db\logs::set('api:report:sum:invalid:year', $this->user_id, $log_meta);
			\lib\debug::error(T_("Invalid input year"), 'year', 'arguments');
			return false;
		}

		if($month && intval($month) < 10)
		{
			$month = '0'. (string) intval($month);
		}

		if($month && (!is_numeric($month) || mb_strlen($month) !== 2))
		{
			\lib\db\logs::set('api:report:sum:invalid:month', $this->user_id, $log_meta);
			\lib\debug::error(T_("Invalid input month"), 'month', 'arguments');
			return false;
		}

		if($day && intval($day) < 10)
		{
			$day = '0'. (string) intval($day);
		}

		if($day && (!is_numeric($day) || mb_strlen($day) !== 2))
		{
			\lib\db\logs::set('api:report:sum:invalid:day', $this->user_id, $log_meta);
			\lib\debug::error(T_("Invalid input day"), 'day', 'arguments');
			return false;
		}

		$date_is_shamsi = false;
		if($year && intval($year) > 1300 && intval($year) < 1600)
		{
			$date_is_shamsi = true;
		}

		$user = \lib\utility::request('user');
		$user = \lib\utility\shortURL::decode($user);
		if($user)
		{
			$check_user_in_team = \lib\db\userteams::get(['team_id' => $id, 'user_id' => $user, 'limit' => 1, 'rule'=> ['IN', '("user", "admin")']]);

			if(!$check_is_my_team || !isset($check_is_my_team['userteam_id']))
			{
				\lib\db\logs::set('api:report:sum:user:is:not:in:team', $this->user_id, $log_meta);
				\lib\debug::error(T_("This user is not in this team"), 'user', 'arguments');
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
		$meta['export']  	    = \lib\utility::request('export');
		$result                 = \lib\db\hours::sum_time($meta);

		$temp = [];
		foreach ($result as $key => $value)
		{
			$check = $this->ready_sum_report($value);
			if($check)
			{
				$temp[] = $check;
			}
		}
		if(\lib\utility::request('export'))
		{
			\lib\utility\export::csv(['data' => $temp, 'name' => T_("tejarak-sum-report")]);
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
	public function ready_sum_report($_data)
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