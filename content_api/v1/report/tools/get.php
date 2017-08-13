<?php
namespace content_api\v1\report\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait get
{
	use last;
	use sum;
	use u;
	use year;
	use month;
	use period;
	use report_list;


	/**
	 * Gets the report result.
	 *
	 * @param      <type>  $_report_type  The report type
	 */
	public function get_report_result($_report_type)
	{
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => utility::request(),
			],
		];

		if(!$this->user_id)
		{
			return false;
		}


		$id = utility::request('id');
		$id = utility\shortURL::decode($id);
		if(!$id)
		{
			logs::set('api:report:get:team:not:found', $this->user_id, $log_meta);
			debug::error(T_("Team id not set"), 'id', 'arguments');
			return false;
		}


		if(!$check_is_my_team = \lib\db\teams::access_team_id($id, $this->user_id, ['action'=> 'admin']))
		{
			logs::set('api:report:list:access:deniy', $this->user_id, $log_meta);
			debug::error(T_("Can not access to load this team details"), 'id', 'permission');
			return false;
		}

		if(!isset($check_is_my_team['id']))
		{
			logs::set('api:report:get:team:id:not:found', $this->user_id, $log_meta);
			debug::error(T_("Invalid team data"), 'id', 'system');
			return false;
		}

		// run the function
		switch ($_report_type)
		{
			case 'thismonth':
			case 'today':
			case 'lasttraffic':
			case 'present':
			case 'absent':
			case 'members':
			case 'memberstatus':
			case 'last24hour':
			if(utility::request('format') == 'im')
			{
				$msg = new \lib\utility\message($id);
				$msg->message_type($_report_type);
				$result = $msg->get_message_text();
				return $result;
			}
			else
			{
				\lib\error::page(T_("Invalid url"));
			}
			break;

			default:
				\lib\error::page(T_("Invalid url"));
				break;
		}
	}

}
?>