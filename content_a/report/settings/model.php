<?php
namespace content_a\report\settings;
use \lib\debug;
use \lib\utility;
use \lib\db\logs;

class model extends \content_a\main\model
{
	public function post_settings($_args)
	{
		$log_meta =
		[
			'meta' =>
			[
				'input'   => utility::post(),
				'session' => $_SESSION,
			]
		];

		$team_code = null;
		if(isset($_args->match->url[0][1]))
		{
			$team_code = $_args->match->url[0][1];
		}

		$team_id = null;

		if($team_code)
		{
			$team_id = \lib\utility\shortURL::decode($team_code);
		}

		if(!$team_id)
		{
			logs::set('team:id:not:found:teport:setting', $this->login('id'), $log_meta);
			debug::error(T_("Team id not found"));
			return false;
		}

		$update_team = [];
		if(utility::post('reportHeader') && mb_strlen(utility::post('reportHeader')) > 255)
		{
			logs::set('report:header:max:leng', $this->login('id'), $log_meta);
			debug::error(T_("Can not set report header larger than 255 character"), 'reportHeader');
			return false;
		}

		if(utility::post('reportFooter') && mb_strlen(utility::post('reportFooter')) > 255)
		{
			logs::set('report:footer:max:leng', $this->login('id'), $log_meta);
			debug::error(T_("Can not set report footer larger than 255 character"), 'reportFooter');
			return false;
		}

		$update_team['reportheader'] = utility::post('reportHeader');

		$update_team['reportfooter'] = utility::post('reportFooter');

		if(!empty($update_team))
		{
			\lib\db\teams::update($update_team, $team_id);
		}

		$update_user_teams = [];
		$args              = [];
		$args['id']        = \lib\router::get_url(0);
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

		foreach (utility::post() as $key => $value)
		{
			if(preg_match("/^(daily|enterexit)\_(.*)$/", $key, $split))
			{
				$userteam_id = \lib\utility\shortURL::decode($split[2]);
				if($userteam_id)
				{
					$update_user_teams[$userteam_id]['report'. $split[1]] = 1;
				}
			}
		}

		if(!empty($update_user_teams))
		{
			foreach ($update_user_teams as $key => $value)
			{
				\lib\db\userteams::update($value, $key);
			}
		}

		if(debug::$status)
		{
			debug::true(T_("Report settings was changed"));
		}
	}
}
?>