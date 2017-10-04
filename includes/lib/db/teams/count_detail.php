<?php
namespace lib\db\teams;
trait count_detail
{
	/**
	 * { function_description }
	 *
	 * @param      <type>  $_team_id  The team identifier
	 */
	public static function count_detail($_team_ids, $_encode_key = false)
	{
		if(is_numeric($_team_ids))
		{
			$_team_ids = [$_team_ids];
		}

		if(!is_array($_team_ids))
		{
			return false;
		}

		$team_ids = implode(',', $_team_ids);
		$resutl = [];

		$member_count =
		"
			SELECT
				COUNT(*) AS `count`,
				userteams.team_id AS `teamid`
			FROM
				userteams
			WHERE
				userteams.status IN ('active', 'deactive') AND
				userteams.rule IN ('user', 'admin')
			GROUP BY teamid
			HAVING userteams.team_id IN ($team_ids)
		";

		$member_count = \lib\db::get($member_count, ['teamid', 'count']);

		$last_traffic =
		"
			SELECT
				CONCAT(hourlogs.date, ' ', hourlogs.time) AS `hourdate`,
				hourlogs.team_id AS `teamid`
			FROM
				hourlogs
			GROUP BY hourdate, teamid
			HAVING hourlogs.team_id IN ($team_ids)
		";
		$last_traffic = \lib\db::get($last_traffic, ['teamid', 'hourdate']);

		$traffic_count = "SELECT COUNT(*) AS `count`, hourlogs.team_id AS `teamid` FROM hourlogs  GROUP BY teamid HAVING hourlogs.team_id IN ($team_ids) ";
		$traffic_count = \lib\db::get($traffic_count, ['teamid', 'count']);

		$i = max(count($member_count), count($last_traffic), count($traffic_count));

		if(count($member_count) === $i)	 $larger_array = $member_count;
		if(count($last_traffic) === $i)	 $larger_array = $last_traffic;
		if(count($traffic_count) === $i) $larger_array = $traffic_count;

		$resutl = [];
		foreach ($larger_array as $key => $value)
		{
			$my_key = $key;
			if($_encode_key)
			{
				$my_key = \lib\utility\shortURL::encode($key);
			}

			if(array_key_exists($key, $member_count))
			{
				$resutl[$my_key]['member_count'] = $member_count[$key];
			}

			if(array_key_exists($key, $last_traffic))
			{
				$resutl[$my_key]['last_traffic'] = $last_traffic[$key];
				$resutl[$my_key]['last_traffic_string'] = \lib\utility::humanTiming($last_traffic[$key]);
			}

			if(array_key_exists($key, $traffic_count))
			{
				$resutl[$my_key]['traffic_count'] = $traffic_count[$key];
			}
		}
		return $resutl;
	}
}