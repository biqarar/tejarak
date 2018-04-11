<?php
namespace content_api\v1\report\tools;


trait last
{

	/**
	 * Gets the report.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The report.
	 */
	public function report_last_time()
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

		$user_id = null;
		$user    = \dash\utility::request('user');

		if($user)
		{
			$user_id = \dash\coding::decode($user);
			if(!$user_id)
			{
				\dash\db\logs::set('api:report:user:id:set:but:is:not:valid', $this->user_id, $log_meta);
				\dash\notif::error(T_("Invalid user id"), 'user', 'arguments');
				return false;
			}
		}

		$check_is_my_team = null;

		if($user_id)
		{
			if(!$check_is_my_team = \lib\db\teams::access_team_id($id, $this->user_id, ['action' => 'report_last_all']))
			{
				\dash\db\logs::set('api:report:team:permission:denide', $this->user_id, $log_meta);
				\dash\notif::error(T_("Can not access to load detail of this team"), 'team', 'permission');
				return false;
			}
		}
		else
		{
			if($check_is_my_team = \lib\db\teams::access_team_id($id, $this->user_id, ['action'=> 'report_last_all']))
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
				\dash\db\logs::set('api:report:last:permission:denide', $this->user_id, $log_meta);
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

		$meta            = [];
		$meta['team_id'] = $check_is_my_team['id'];

		if($user_id)
		{
			$meta['user_id'] = $user_id;
		}

		$meta['order']      = 'DESC';
		$meta['pagenation'] = \dash\utility::request('export') ? false : true;

		if(!$meta['pagenation'])
		{
			$meta['limit'] = null;
		}

		$result          = \lib\db\hours::search(null, $meta);

		$temp = [];
		foreach ($result as $key => $value)
		{
			$check = $this->ready_last_report($value);
			if($check)
			{
				$temp[] = $check;
			}
		}

		if(\dash\utility::request('export'))
		{
			\dash\utility\export::csv(['data'=> $temp, 'name' => T_('tejarak-last-report')]);
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
	public function ready_last_report($_data)
	{
		$temp = [];
		foreach ($_data as $key => $value)
		{
			switch ($key)
			{
				case 'hour_id':
					$temp['id'] = \dash\coding::encode($value);
					break;

				case 'date':
					$temp['date'] = strtotime($value);
					$temp['date_string'] = $value;
					break;

				case 'enddate':
					$temp['end_date'] = strtotime($value);
					$temp['end_date_string'] = $value;
					break;

				case 'shamsi_date':
					$temp['shamsi_date'] = $value;
					break;

				case 'endshamsi_date':
					$temp['end_shamsi_date'] = $value;
					break;

				case 'start':
				case 'end':
				case 'diff':
				case 'minus':
				case 'plus':
				case 'type':
				case 'accepted':
				case 'total':
				case 'personnelcode':
				case 'postion':
				case 'displayname':
				case 'firstname':
				case 'lastname':
				case 'sort':
					$temp[$key] = $value;
					break;

				default:
					continue;
					break;
			}
		}
		krsort($temp);
		return $temp;
	}

}
?>