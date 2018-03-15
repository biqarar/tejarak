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
				'input'   => \lib\utility::post(),
				'session' => $_SESSION,
			]
		];

		$team_code = \lib\url::dir(0);


		$team_id = null;

		if($team_code)
		{
			$team_id = \lib\utility\shortURL::decode($team_code);
		}

		if(!$team_id)
		{
			logs::set('team:id:not:found:teport:setting', $this->login('id'), $log_meta);
			\lib\debug::error(T_("Team id not found"));
			return false;
		}

		if(\lib\utility::post('deleteGroup'))
		{
			\lib\db\teams::update(['telegram_id' => null], $team_id);
			\lib\debug::warn(T_("The telegram group was removed"));
			return;
		}

		$update_team = [];
		if(\lib\utility::post('reportHeader') && mb_strlen(\lib\utility::post('reportHeader')) > 255)
		{
			logs::set('report:header:max:leng', $this->login('id'), $log_meta);
			\lib\debug::error(T_("Can not set report header larger than 255 character"), 'reportHeader');
			return false;
		}

		if(\lib\utility::post('reportFooter') && mb_strlen(\lib\utility::post('reportFooter')) > 255)
		{
			logs::set('report:footer:max:leng', $this->login('id'), $log_meta);
			\lib\debug::error(T_("Can not set report footer larger than 255 character"), 'reportFooter');
			return false;
		}

		$access = \lib\db\teams::access_team_id($team_id, $this->login('id'), ['action' => 'admin']);

		if(!$access)
		{
			\lib\db\logs::set('report:settings:no:access:to:change:settings', $this->login('id'));
			\lib\debug::error(T_("No access to change settings"), 'team');
			return false;
		}


		if(\lib\utility::post('timed_auto_report_time'))
		{
			if(!preg_match("/^\d{2}\:\d{2}$/", \lib\utility::post('timed_auto_report_time')))
			{
				\lib\db\logs::set('report:settings:invalid:timed_auto_report_time', $this->login('id'));
				\lib\debug::error(T_("Invalid timed auto report time"), 'timed_auto_report_time');
				return false;
			}

			$time_changed = \lib\utility\timezone::change_time('H:i', \lib\utility::post('timed_auto_report_time'), "Asia/Tehran");
			$update_team['timed_auto_report'] = $time_changed;
		}
		else
		{
			$update_team['timed_auto_report'] = null;

		}


		$update_team['reportheader'] = \lib\utility::post('reportHeader');

		$update_team['reportfooter'] = \lib\utility::post('reportFooter');

		$update_user_teams = [];
		$args              = [];
		$args['id']        = \lib\url::dir(0);
		$admins            = \lib\db\userteams::get_admins($args);
		$admins = array_map(function($_a)
		{
			if(isset($_a['id']))
			{
				$_a['id'] = \lib\utility\shortURL::decode($_a['id']);
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

		foreach (\lib\utility::post() as $key => $value)
		{
			if(preg_match("/^(daily|enterexit)\_(.*)$/", $key, $split))
			{
				$userteam_id = \lib\utility\shortURL::decode($split[2]);
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

		if(\lib\debug::$status)
		{
			\lib\debug::true(T_("Report settings was changed"));
		}
	}
}
?>