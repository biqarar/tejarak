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

		$end_date   = date("Y-m-d");
		$start_date = date('Y-m-d',strtotime("-1 days"));
		$time       = date("H:i");

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
				TIME(hours.start) <= TIME('$time') AND
				(
					(
						DATE(hours.date) >= DATE('$start_date') AND
						DATE(hours.date) <= DATE('$end_date')
					)
					OR
					(
						DATE(hours.enddate) >= DATE('$start_date') AND
						DATE(hours.enddate) <= DATE('$end_date')
					)
				)
			ORDER BY hours.id ASC
		";
		$resutl = \lib\db::get($query);
		return $resutl;
	}
}