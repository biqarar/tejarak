<?php
namespace content_api\v1\report\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait get
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

		$team = utility::request('team');
		if(!$team)
		{
			logs::set('api:report:team:not:found', $this->user_id, $log_meta);
			debug::error(T_("Team not set"), 'team', 'arguments');
			return false;
		}

		if(!$check_is_my_team = \lib\db\teams::access_team($team, $this->user_id, ['action'=> 'report_last']))
		{
			logs::set('api:report:team:permission:denide', $this->user_id, $log_meta);
			debug::error(T_("Can not access to load detail of this team"), 'team', 'permission');
			return false;
		}

		if(!isset($check_is_my_team['id']))
		{
			logs::set('api:report:team:id:not:found', $this->user_id, $log_meta);
			debug::error(T_("Invalid team data"), 'team', 'system');
			return false;
		}

		$branch = utility::request('branch');
		// report is not a branch !
		if($branch === 'report')
		{
			$branch = null;
		}

		if($branch)
		{
			if(!$branch_detail = \lib\db\branchs::get_by_brand($team, $branch))
			{
				logs::set('api:report:branch:team:not:mathc', $this->user_id, $log_meta);
				debug::error(T_("Invalid branch name"), 'branch', 'arguments');
				return false;
			}
		}

		$meta            = [];
		$meta['team_id'] = $check_is_my_team['id'];
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
				case 'date':
					$temp[$key] = strtotime($value);
					break;
				case 'start':
				case 'end':
				case 'diff':
				case 'minus':
				case 'plus':
				case 'type':
				case 'accepted':
				case 'name':
				case 'family':
				case 'displayname':
				case 'postion':

					$temp[$key] = $value;
					break;
				case 'shamsi_date':
				case 'id':
				case 'user_id':
				case 'team_id':
				case 'userteam_id':
				case 'userbranch_id':
				case 'start_getway_id':
				case 'end_getway_id':
				case 'start_userbranch_id':
				case 'end_userbranch_id':
				case 'year':
				case 'month':
				case 'day':
				case 'shamsi_year':
				case 'shamsi_month':
				case 'shamsi_day':
				case 'createdate':
				case 'date_modified':
				case 'status':
				default:
					continue;
					break;
			}
		}
		return $temp;
	}

}
?>