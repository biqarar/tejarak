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

		$date = date("Y-m-d");

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
					hours.date = '$date' OR
					hours.enddate = '$date'
				)
			ORDER BY hours.id ASC
		";
		$resutl = \lib\db::get($query);

		return $resutl;
	}
}