<?php
namespace lib\db\teams;
trait report
{
	/**
	 * { function_description }
	 *
	 * @param      <type>  $_team_id  The team identifier
	 */
	public static function timed_auto_report_query($_team_id)
	{
		if(!$_team_id || !is_numeric($_team_id))
		{
			return false;
		}

		$now       = date("Y-m-d H:i:s");

		$query =
		"
			SELECT
				hours.*,
				userteams.*,
				userteams.id AS `userteam_id`
			FROM
				hours
			INNER JOIN userteams ON userteams.id = hours.userteam_id
			WHERE
				userteams.team_id = $_team_id AND
				(
					hours.start_time >= DATE_SUB('$now', INTERVAL 24 HOUR) OR
					hours.end_time >= DATE_SUB('$now', INTERVAL 24 HOUR)
				)
			ORDER BY hours.id ASC
		";

		$resutl = \dash\db::get($query);

		return $resutl;
	}
}