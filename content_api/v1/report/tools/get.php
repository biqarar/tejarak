<?php
namespace content_api\v1\report\tools;


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
				'input' => \lib\utility::request(),
			],
		];

		if(!$this->user_id)
		{
			return false;
		}


		$id = \lib\utility::request('id');
		$id = \lib\coding::decode($id);
		if(!$id)
		{
			\dash\db\logs::set('api:report:get:team:not:found', $this->user_id, $log_meta);
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
			\dash\db\logs::set('api:report:get:team:id:not:found', $this->user_id, $log_meta);
			\lib\notif::error(T_("Invalid team data"), 'id', 'system');
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
			if(\lib\utility::request('format') == 'im')
			{
				$msg = new \lib\utility\message($id);
				$msg->type($_report_type);
				$result = $msg->get_message_text();
				if(is_array($result))
				{
					sort($result);
					if(isset($result[0]))
					{
						$result = $result[0];
					}
				}

            	if(!$result)
            	{
            		$result = T_("Report not found");
            	}

				return $result;
			}
			else
			{
				\lib\header::status(404, T_("Invalid parameter format"));
			}
			break;

			default:
				\lib\header::status(404, T_("Invalid url"));
				break;
		}
	}

}
?>