<?php
namespace content_a\setting\report;


class model extends \content_a\main\model
{
	public function post_report($_args)
	{


		$log_meta =
		[
			'meta' =>
			[
				'input'   => \dash\request::post(),
				'session' => $_SESSION,
			]
		];

		$team_code = \dash\url::dir(0);


		$team_id = null;

		if($team_code)
		{
			$team_id = \lib\coding::decode($team_code);
		}

		if(!$team_id)
		{
			logs::set('team:id:not:found:teport:setting', \lib\user::id(), $log_meta);
			\lib\notif::error(T_("Team id not found"));
			return false;
		}

		if(\dash\request::post('deleteGroup'))
		{
			\lib\db\teams::update(['telegram_id' => null], $team_id);
			\lib\notif::warn(T_("The telegram group was removed"));
			return;
		}

		$update_team = [];
		if(\dash\request::post('reportHeader') && mb_strlen(\dash\request::post('reportHeader')) > 255)
		{
			logs::set('report:header:max:leng', \lib\user::id(), $log_meta);
			\lib\notif::error(T_("Can not set report header larger than 255 character"), 'reportHeader');
			return false;
		}

		if(\dash\request::post('reportFooter') && mb_strlen(\dash\request::post('reportFooter')) > 255)
		{
			logs::set('report:footer:max:leng', \lib\user::id(), $log_meta);
			\lib\notif::error(T_("Can not set report footer larger than 255 character"), 'reportFooter');
			return false;
		}

		$access = \lib\db\teams::access_team_id($team_id, \lib\user::id(), ['action' => 'admin']);

		if(!$access)
		{
			\dash\db\logs::set('report:settings:no:access:to:change:settings', \lib\user::id());
			\lib\notif::error(T_("No access to change settings"), 'team');
			return false;
		}


		if(\dash\request::post('timed_auto_report_time'))
		{
			if(!preg_match("/^\d{2}\:\d{2}$/", \dash\request::post('timed_auto_report_time')))
			{
				\dash\db\logs::set('report:settings:invalid:timed_auto_report_time', \lib\user::id());
				\lib\notif::error(T_("Invalid timed auto report time"), 'timed_auto_report_time');
				return false;
			}

			$time_changed = \lib\utility\timezone::change_time('H:i', \dash\request::post('timed_auto_report_time'), "Asia/Tehran");
			$update_team['timed_auto_report'] = $time_changed;
		}
		else
		{
			$update_team['timed_auto_report'] = null;

		}


		$update_team['reportheader'] = \dash\request::post('reportHeader');

		$update_team['reportfooter'] = \dash\request::post('reportFooter');

		$update_user_teams = [];
		$args              = [];
		$args['id']        = \dash\url::dir(0);
		$admins            = \lib\db\userteams::get_admins($args);
		$admins = array_map(function($_a)
		{
			if(isset($_a['id']))
			{
				$_a['id'] = \lib\coding::decode($_a['id']);
			}
			return $_a;
		}, $admins);

		foreach ($admins as $key => $value)
		{
			if(isset($value['id']))
			{
				$update_user_teams[$value['id']]['reportdaily']     = 0;
				$update_user_teams[$value['id']]['reportenterexit'] = 0;
			}
		}

		$report_settings = \lib\db\teams::$default_settings;

		foreach (\dash\request::post() as $key => $value)
		{
			if(preg_match("/^(daily|enterexit)\_(.*)$/", $key, $split))
			{
				$userteam_id = \lib\coding::decode($split[2]);
				if($userteam_id)
				{
					$update_user_teams[$userteam_id]['report'. $split[1]] = 1;
				}
			}

			if(preg_match("/^send(.*)$/", $key, $split))
			{
				if(is_numeric($value))
				{
					$report_settings[$split[1]] = $value;
				}
				else
				{
					$report_settings[$split[1]] = true;
				}
			}
		}

		if(!empty($update_team))
		{
			// get old meta and merge old meta by new meta
			$get_old_meta = \lib\db\teams::get_by_id($team_id);

			if(array_key_exists('meta', $get_old_meta))
			{
				if(!$get_old_meta['meta'])
				{
					$update_team['meta'] = json_encode(['report_settings' => $report_settings], JSON_UNESCAPED_UNICODE);
				}
				elseif(is_string($get_old_meta['meta']) && substr($get_old_meta['meta'], 0, 1) === '{')
				{
					$temp = json_decode($get_old_meta['meta'], true);
					$temp = array_merge($temp, ['report_settings' => $report_settings]);
					$update_team['meta'] = json_encode($temp, JSON_UNESCAPED_UNICODE);
				}
				elseif(is_array($get_old_meta['meta']))
				{
					$temp = array_merge($get_old_meta['meta'], ['report_settings' => $report_settings]);
					$update_team['meta'] = json_encode($temp, JSON_UNESCAPED_UNICODE);
				}
				else
				{
					$update_team['meta'] = json_encode(['report_settings' => $report_settings], JSON_UNESCAPED_UNICODE);
				}
			}

			\lib\db\teams::update($update_team, $team_id);
		}

		if(!empty($update_user_teams))
		{
			foreach ($update_user_teams as $key => $value)
			{
				\lib\db\userteams::update($value, $key);
			}
		}

		if(\lib\engine\process::status())
		{
			\lib\notif::ok(T_("Report settings was changed"));
		}
	}
}
?>