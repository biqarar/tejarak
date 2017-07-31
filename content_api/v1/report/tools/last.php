<?php
namespace content_api\v1\report\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

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
				'input' => utility::request(),
			],
		];

		$id = utility::request('id');
		$id = utility\shortURL::decode($id);

		if(!$id)
		{
			logs::set('api:report:team:not:found', $this->user_id, $log_meta);
			debug::error(T_("Team id not set"), 'team', 'arguments');
			return false;
		}

		$user_id = null;
		$user    = utility::request('user');

		if($user)
		{
			$user_id = utility\shortURL::decode($user);
			if(!$user_id)
			{
				logs::set('api:report:user:id:set:but:is:not:valid', $this->user_id, $log_meta);
				debug::error(T_("Invalid user id"), 'user', 'arguments');
				return false;
			}
		}

		$check_is_my_team = null;

		if($user_id)
		{
			if(!$check_is_my_team = \lib\db\teams::access_team_id($id, $this->user_id, ['action' => 'report_last_all']))
			{
				logs::set('api:report:team:permission:denide', $this->user_id, $log_meta);
				debug::error(T_("Can not access to load detail of this team"), 'team', 'permission');
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
				logs::set('api:report:last:permission:denide', $this->user_id, $log_meta);
				debug::error(T_("Can not access to load detail of this team"), 'team', 'permission');
				return false;
			}
		}

		if(!isset($check_is_my_team['id']))
		{
			logs::set('api:report:team:id:not:found', $this->user_id, $log_meta);
			debug::error(T_("Invalid team data"), 'team', 'system');
			return false;
		}

		$meta            = [];
		$meta['team_id'] = $check_is_my_team['id'];

		if($user_id)
		{
			$meta['user_id'] = $user_id;
		}

		$meta['order']   = 'DESC';
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
		return $temp;
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
					$temp['id'] = \lib\utility\shortURL::encode($value);
					break;

				case 'date':
					$temp['date'] = strtotime($value);
					break;

				case 'enddate':
					$temp['end_date'] = strtotime($value);
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