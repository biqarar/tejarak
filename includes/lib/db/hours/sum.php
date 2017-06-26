<?php
namespace lib\db\hours;

trait sum
{
// 	id
// user_id
// team_id
// userteam_id
// start_gateway_id
// end_gateway_id
// start_userteam_id
// end_userteam_id
// date
// year
// month
// day
// shamsi_date
// shamsi_year
// shamsi_month
// shamsi_day
// start
// end
// diff
// minus
// plus
// type
// accepted
// total
// createdate
// date_modified
// status
// enddate
// endyear
// endmonth
// endday
// endshamsi_date
// endshamsi_year
// endshamsi_month
// endshamsi_day

	/**
	 * result as sum time
	 *
	 * @param      array  $_args  The arguments
	 */
	public static function sum_time($_args = [])
	{
		$team_id        = $_args['team_id'];
		$user_id        = $_args['user_id'];
		$userteam_id    = $_args['userteam_id'];
		$year           = $_args['year'];
		$month          = $_args['month'];
		$day            = $_args['day'];
		$date_is_shamsi = $_args['date_is_shamsi'];

		$query            = null;
		$pagenation_query = null;

		// year and month and day
		if($year && $month && $day)
		{
			// year and month and day
			// user id is set
			if($user_id)
			{
				// year and month and day
				// user id is set
				// date is shamsi
				if($date_is_shamsi)
				{
					$pagenation_query =
					"SELECT COUNT(*) AS `count` FROM
							hours
						WHERE
							hours.shamsi_year  = '$year' AND
							hours.shamsi_month = '$month' AND
							hours.shamsi_day   = '$day' AND
							hours.userteam_id  = $userteam_id";
					$query =
					"
						SELECT
							hours.shamsi_year	 AS `year`,
							hours.shamsi_month	 AS `month`,
							hours.shamsi_day	 AS `day`,
							hours.start			 AS `start`,
							hours.end			 AS `end`,
							hours.diff			 AS `diff`,
							hours.minus			 AS `minus`,
							hours.plus			 AS `plus`,
							hours.type			 AS `type`,
							hours.accepted		 AS `accepted`,
							hours.total			 AS `total`
						FROM
							hours
						WHERE
							hours.shamsi_year  = '$year' AND
							hours.shamsi_month = '$month' AND
							hours.shamsi_day   = '$day' AND
							hours.userteam_id  = $userteam_id
						LIMIT %d, %d
					";
				}
				else
				{
					// year and month and day
					// user id is set
					// date is geregorian
					$pagenation_query =
					"SELECT COUNT(*) AS `count` FROM
							hours
						WHERE
							hours.year        = '$year'  AND
							hours.month       = '$month' AND
							hours.day         = '$day' 	 AND
							hours.userteam_id = $userteam_id";
					$query =
					"
						SELECT
							hours.year 		AS `year`,
							hours.month 	AS `month`,
							hours.day 		AS `day`,
							hours.start 	AS `start`,
							hours.end 		AS `end`,
							hours.diff 		AS `diff`,
							hours.minus 	AS `minus`,
							hours.plus 		AS `plus`,
							hours.type 		AS `type`,
							hours.accepted 	AS `accepted`,
							hours.total 	AS `total`
						FROM
							hours
						WHERE
							hours.year        = '$year'  AND
							hours.month       = '$month' AND
							hours.day         = '$day' 	 AND
							hours.userteam_id = $userteam_id
						LIMIT %d, %d
					";
				}
			}
			else
			{
				// year and month and day
				// user id is not set
				// date is shamsi
				if($date_is_shamsi)
				{
					$pagenation_query =
					"SELECT COUNT(*) AS `count` FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users ON users.id = userteams.user_id
						WHERE
							hours.shamsi_year  = '$year' AND
							hours.shamsi_month = '$month' AND
							hours.shamsi_day   = '$day'";
					$query =
					"
						SELECT
							GROUP_CONCAT(DISTINCT userteams.displayname) 			AS `displayname`,
							GROUP_CONCAT(DISTINCT userteams.firstname, userteams.lastname SEPARATOR ' ') AS `name`,
							GROUP_CONCAT(DISTINCT users.user_mobile) 				AS `mobile`,
							COUNT(*) 				AS `count`,
							SUM(hours.diff) 		AS `diff`,
							SUM(hours.minus) 		AS `minus`,
							SUM(hours.plus) 		AS `plus`,
							SUM(hours.accepted) 	AS `accepted`,
							SUM(hours.total) 		AS `total`
						FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users ON users.id = userteams.user_id
						WHERE
							hours.shamsi_year  = '$year' AND
							hours.shamsi_month = '$month' AND
							hours.shamsi_day   = '$day'
						GROUP BY userteams.id
						LIMIT %d, %d
					";
				}
				else
				{
					// year and month and day
					// user id is not set
					// date is geregorian
					$pagenation_query =
					"SELECT COUNT(*) AS `count` FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users ON users.id = userteams.user_id
						WHERE
							hours.year  = '$year' AND
							hours.month = '$month' AND
							hours.day   = '$day'";
					$query =
					"
						SELECT
							GROUP_CONCAT(DISTINCT userteams.displayname) 			AS `displayname`,
							GROUP_CONCAT(DISTINCT userteams.firstname, userteams.lastname SEPARATOR ' ') AS `name`,
							GROUP_CONCAT(DISTINCT users.user_mobile) 				AS `mobile`,
							COUNT(*) 				AS `count`,
							SUM(hours.diff) 		AS `diff`,
							SUM(hours.minus) 		AS `minus`,
							SUM(hours.plus) 		AS `plus`,
							SUM(hours.accepted) 	AS `accepted`,
							SUM(hours.total) 		AS `total`
						FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users ON users.id = userteams.user_id
						WHERE
							hours.year  = '$year' AND
							hours.month = '$month' AND
							hours.day   = '$day'
						GROUP BY userteams.id
						LIMIT %d, %d
					";
				}
			}
		}
		elseif($year && $month && !$day)
		{
			// year and month
			// user id is set
			if($user_id)
			{
				// year and month
				// user id is set
				// date is shamsi
				if($date_is_shamsi)
				{
					$pagenation_query =
					"SELECT COUNT(*) AS `count` FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users ON users.id = userteams.user_id
						WHERE
							hours.shamsi_year  = '$year' AND
							hours.shamsi_month = '$month' AND
							userteams.id       = $userteam_id";
					$query =
					"
						SELECT
							hours.shamsi_day			 			AS `day`,
							GROUP_CONCAT(DISTINCT userteams.displayname) 			AS `displayname`,
							GROUP_CONCAT(DISTINCT userteams.firstname, userteams.lastname SEPARATOR ' ') AS `name`,
							GROUP_CONCAT(DISTINCT users.user_mobile) 				AS `mobile`,
							COUNT(*) 				AS `count`,
							SUM(hours.diff) 		AS `diff`,
							SUM(hours.minus) 		AS `minus`,
							SUM(hours.plus) 		AS `plus`,
							SUM(hours.accepted) 	AS `accepted`,
							SUM(hours.total) 		AS `total`
						FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users ON users.id = userteams.user_id
						WHERE
							hours.shamsi_year  = '$year' AND
							hours.shamsi_month = '$month' AND
							userteams.id       = $userteam_id
						GROUP BY hours.shamsi_year, hours.shamsi_month, hours.shamsi_day
						LIMIT %d, %d
					";
				}
				else
				{
					// year and month
					// user id is set
					// date is geregorian
					$pagenation_query =
					"SELECT COUNT(*) AS `count` FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users ON users.id = userteams.user_id
						WHERE
							hours.year   = '$year' AND
							hours.month  = '$month' AND
							userteams.id = $userteam_id";
					$query =
					"
						SELECT
							hours.day			 			AS `day`,
							GROUP_CONCAT(DISTINCT userteams.displayname) 			AS `displayname`,
							GROUP_CONCAT(DISTINCT userteams.firstname, userteams.lastname SEPARATOR ' ') AS `name`,
							GROUP_CONCAT(DISTINCT users.user_mobile) 				AS `mobile`,
							COUNT(*) 				AS `count`,
							SUM(hours.diff) 		AS `diff`,
							SUM(hours.minus) 		AS `minus`,
							SUM(hours.plus) 		AS `plus`,
							SUM(hours.accepted) 	AS `accepted`,
							SUM(hours.total) 		AS `total`
						FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users ON users.id = userteams.user_id
						WHERE
							hours.year   = '$year' AND
							hours.month  = '$month' AND
							userteams.id = $userteam_id
						GROUP BY hours.year, hours.month, hours.day
						LIMIT %d, %d
					";
				}
			}
			else
			{
				// year and month
				// user id is not set
				// date is shamsi
				if($date_is_shamsi)
				{
					$pagenation_query =
					"SELECT COUNT(*) AS `count` FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users ON users.id = userteams.user_id
						WHERE
							hours.shamsi_year  = '$year' AND
							hours.shamsi_month = '$month'";
					$query =
					"
						SELECT
							hours.shamsi_day			 			AS `day`,
							GROUP_CONCAT(DISTINCT userteams.displayname) 			AS `displayname`,
							GROUP_CONCAT(DISTINCT userteams.firstname, userteams.lastname SEPARATOR ' ') AS `name`,
							GROUP_CONCAT(DISTINCT users.user_mobile) 				AS `mobile`,
							COUNT(*) 				AS `count`,
							SUM(hours.diff) 		AS `diff`,
							SUM(hours.minus) 		AS `minus`,
							SUM(hours.plus) 		AS `plus`,
							SUM(hours.accepted) 	AS `accepted`,
							SUM(hours.total) 		AS `total`
						FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users ON users.id = userteams.user_id
						WHERE
							hours.shamsi_year  = '$year' AND
							hours.shamsi_month = '$month'
						GROUP BY userteams.id, hours.shamsi_year, hours.shamsi_month, hours.shamsi_day
						LIMIT %d, %d

					";
				}
				else
				{
					// year and month
					// user id is not set
					// date is geregorian
					$pagenation_query =
					"SELECT COUNT(*) AS `count` FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users ON users.id = userteams.user_id
						WHERE
							hours.year  = '$year' AND
							hours.month = '$month'";
					$query =
					"
						SELECT
							hours.day			AS `day`,
							GROUP_CONCAT(DISTINCT userteams.displayname) 			AS `displayname`,
							GROUP_CONCAT(DISTINCT userteams.firstname, userteams.lastname SEPARATOR ' ') AS `name`,
							GROUP_CONCAT(DISTINCT users.user_mobile) 				AS `mobile`,
							COUNT(*) 				AS `count`,
							SUM(hours.diff) 		AS `diff`,
							SUM(hours.minus) 		AS `minus`,
							SUM(hours.plus) 		AS `plus`,
							SUM(hours.accepted) 	AS `accepted`,
							SUM(hours.total) 		AS `total`
						FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users ON users.id = userteams.user_id
						WHERE
							hours.year  = '$year' AND
							hours.month = '$month'
						GROUP BY userteams.id, hours.year, hours.month, hours.day
						LIMIT %d, %d
					";
				}
			}
		}
		elseif($year && !$month && !$day)
		{
			// year
			// user id is set
			if($user_id)
			{
				// year
				// user id is set
				// date is shamsi
				if($date_is_shamsi)
				{
					$pagenation_query =
					"SELECT COUNT(*) AS `count` FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users ON users.id = userteams.user_id
						WHERE
							hours.shamsi_year  = '$year' AND
							userteams.id       = $userteam_id";
					$query =
					"
						SELECT
							hours.shamsi_month			 			AS `month`,
							GROUP_CONCAT(DISTINCT hours.shamsi_day)			 			AS `day`,
							GROUP_CONCAT(DISTINCT userteams.displayname) 			AS `displayname`,
							GROUP_CONCAT(DISTINCT userteams.firstname, userteams.lastname SEPARATOR ' ') AS `name`,
							GROUP_CONCAT(DISTINCT users.user_mobile) 				AS `mobile`,
							COUNT(*) 				AS `count`,
							SUM(hours.diff) 		AS `diff`,
							SUM(hours.minus) 		AS `minus`,
							SUM(hours.plus) 		AS `plus`,
							SUM(hours.accepted) 	AS `accepted`,
							SUM(hours.total) 		AS `total`
						FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users ON users.id = userteams.user_id
						WHERE
							hours.shamsi_year  = '$year' AND
							userteams.id       = $userteam_id
						GROUP BY hours.shamsi_year, hours.shamsi_month
						LIMIT %d, %d
					";
				}
				else
				{
					// year
					// user id is set
					// date is geregorian
					$pagenation_query =
					"SELECT COUNT(*) AS `count` FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users ON users.id = userteams.user_id
						WHERE
							hours.year  = '$year' AND
							userteams.id = $userteam_id";
					$query =
					"
						SELECT
							GROUP_CONCAT(DISTINCT hours.day)			 			AS `day`,
							hours.month			 			AS `month`,
							GROUP_CONCAT(DISTINCT userteams.displayname) 			AS `displayname`,
							GROUP_CONCAT(DISTINCT userteams.firstname, userteams.lastname SEPARATOR ' ') AS `name`,
							GROUP_CONCAT(DISTINCT users.user_mobile) 				AS `mobile`,
							COUNT(*) 				AS `count`,
							SUM(hours.diff) 		AS `diff`,
							SUM(hours.minus) 		AS `minus`,
							SUM(hours.plus) 		AS `plus`,
							SUM(hours.accepted) 	AS `accepted`,
							SUM(hours.total) 		AS `total`
						FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users ON users.id = userteams.user_id
						WHERE
							hours.year  = '$year' AND
							userteams.id = $userteam_id
						GROUP BY hours.year, hours.month
						LIMIT %d, %d
					";
				}
			}
			else
			{
				// year
				// user id is not set
				// date is shamsi
				if($date_is_shamsi)
				{
					$pagenation_query =
					"SELECT COUNT(*) AS `count` FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users ON users.id = userteams.user_id
						WHERE
							hours.shamsi_year  = '$year'";
					$query =
					"
						SELECT
							GROUP_CONCAT(DISTINCT hours.shamsi_day)			 			AS `day`,
							hours.shamsi_month			 			AS `month`,
							GROUP_CONCAT(DISTINCT userteams.displayname) 			AS `displayname`,
							GROUP_CONCAT(DISTINCT userteams.firstname, userteams.lastname SEPARATOR ' ') AS `name`,
							GROUP_CONCAT(DISTINCT users.user_mobile) 				AS `mobile`,
							COUNT(*) 				AS `count`,
							SUM(hours.diff) 		AS `diff`,
							SUM(hours.minus) 		AS `minus`,
							SUM(hours.plus) 		AS `plus`,
							SUM(hours.accepted) 	AS `accepted`,
							SUM(hours.total) 		AS `total`
						FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users ON users.id = userteams.user_id
						WHERE
							hours.shamsi_year  = '$year'
						GROUP BY userteams.id, hours.shamsi_year, hours.shamsi_month
						LIMIT %d, %d

					";
				}
				else
				{
					// year
					// user id is not set
					// date is geregorian
					$pagenation_query =
					"SELECT COUNT(*) AS `count` FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users ON users.id = userteams.user_id
						WHERE
							hours.year  = '$year'";
					$query =
					"
						SELECT
							GROUP_CONCAT(DISTINCT hours.day) 			AS `day`,
							hours.month 			AS `month`,
							GROUP_CONCAT(DISTINCT userteams.displayname) 			AS `displayname`,
							GROUP_CONCAT(DISTINCT userteams.firstname, userteams.lastname SEPARATOR ' ') AS `name`,
							GROUP_CONCAT(DISTINCT users.user_mobile) 				AS `mobile`,
							COUNT(*) 				AS `count`,
							SUM(hours.diff) 		AS `diff`,
							SUM(hours.minus) 		AS `minus`,
							SUM(hours.plus) 		AS `plus`,
							SUM(hours.accepted) 	AS `accepted`,
							SUM(hours.total) 		AS `total`
						FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users ON users.id = userteams.user_id
						WHERE
							hours.year  = '$year'
						GROUP BY userteams.id, hours.year, hours.month
						LIMIT %d, %d
					";
				}
			}
		}

		$result = [];
		if($query && $pagenation_query)
		{
			$count_record              = \lib\db::get($pagenation_query, 'count', true);
			list($limit_start, $limit) = \lib\db::pagnation((int) $count_record, 10);
			$query                     = sprintf($query, $limit_start, $limit);
			$result                    = \lib\db::get($query);
		}
		return $result;

	}
}
?>