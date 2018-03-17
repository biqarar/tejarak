<?php
namespace content_api\v1\report\tools;


trait u
{

	/**
	 * Gets the report.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The report.
	 */
	public function report_u_time()
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
			\lib\notif::error(T_("Team id not set"), 'team', 'arguments');
			return false;
		}

		if(!$check_is_my_in_team = \lib\db\teams::access_team_id($id, $this->user_id, ['action'=> 'report_u']))
		{
			\lib\db\logs::set('api:report:team:permission:denide', $this->user_id, $log_meta);
			\lib\notif::error(T_("Can not access to load detail of this team"), 'team', 'permission');
			return false;
		}

		if(!isset($check_is_my_in_team['id']) || !isset($check_is_my_in_team['userteam_id']))
		{
			\lib\db\logs::set('api:report:team:id:not:found', $this->user_id, $log_meta);
			\lib\notif::error(T_("Invalid team data"), 'team', 'system');
			return false;
		}

		$meta            = [];
		$meta['userteam_id'] = $check_is_my_in_team['userteam_id'];
		$result          = \lib\db\hours::search(null, $meta);

		$temp = [];
		foreach ($result as $key => $value)
		{
			$check = $this->ready_u_report($value);
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
	public function ready_u_report($_data)
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