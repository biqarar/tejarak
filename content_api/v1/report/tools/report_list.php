<?php
namespace content_api\v1\report\tools;


trait report_list
{
	public function report_list()
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
		$id = \lib\coding::decode($id);
		if(!$id)
		{
			\dash\db\logs::set('api:report:team:not:found', $this->user_id, $log_meta);
			\lib\notif::error(T_("Team id not set"), 'id', 'arguments');
			return false;
		}


		if(!$check_is_my_team = \lib\db\teams::access_team_id($id, $this->user_id, ['action'=> 'admin']))
		{
			\dash\db\logs::set('api:report:list:access:deniy', $this->user_id, $log_meta);
			\lib\notif::error(T_("Can not access to load this team details"), 'id', 'permission');
			return false;
		}

		if(!isset($check_is_my_team['id']))
		{
			\dash\db\logs::set('api:report:team:id:not:found', $this->user_id, $log_meta);
			\lib\notif::error(T_("Invalid team data"), 'id', 'system');
			return false;
		}

		$report_list =
		[
			[
				'title' => T_("This month"),
				'url'   => 'thismonth'
			],
			// [
			// 	'title' => T_("Today"),
			// 	'url'   => 'today'
			// ],
			[
				'title' => T_("Last traffic"),
				'url'   => 'lasttraffic'
			],
			[
				'title' => T_("Present"),
				'url'   => 'present'
			],
			[
				'title' => T_("Absent"),
				'url'   => 'absent'
			],
			[
				'title' => T_("Members"),
				'url'   => 'members'
			],
			// [
			// 	'title' => T_("Members status"),
			// 	'url'   => 'memberstatus'
			// ],
			// [
			// 	'title' => T_("Last 24 hour"),
			// 	'url'   => 'last24hour'
			// ],
		];
		return $report_list;
	}
}
?>