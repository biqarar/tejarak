<?php
namespace lib\app\report;


trait u
{

	/**
	 * Gets the report.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The report.
	 */
	public static function report_u_time()
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

		if(!$check_is_my_in_team = \lib\db\teams::access_team_id($id, \dash\user::id(), ['action'=> 'report_u']))
		{
			\dash\db\logs::set('api:report:team:permission:denide', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Can not access to load detail of this team"), 'team', 'permission');
			return false;
		}

		if(!isset($check_is_my_in_team['id']) || !isset($check_is_my_in_team['userteam_id']))
		{
			\dash\db\logs::set('api:report:team:id:not:found', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Invalid team data"), 'team', 'system');
			return false;
		}

		$meta            = [];
		$meta['userteam_id'] = $check_is_my_in_team['userteam_id'];
		$result          = \lib\db\hours::search(null, $meta);

		$temp = [];
		foreach ($result as $key => $value)
		{
			$check = self::ready_u_report($value);
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
	public static function ready_u_report($_data)
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