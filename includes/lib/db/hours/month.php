<?php
namespace lib\db\hours;

trait month
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
// datemodified
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
	 * result as sum time in month
	 *
	 * @param      array  $_args  The arguments
	 */
	public static function sum_month_time($_args = [])
	{
		$team_id        = isset($_args['team_id']) 		  ? $_args['team_id'] 		 : null;
		$user_id        = isset($_args['user_id']) 		  ? $_args['user_id'] 		 : null;
		$userteam_id    = isset($_args['userteam_id']) 	  ? $_args['userteam_id'] 	 : null;
		$year           = isset($_args['year']) 		  ? $_args['year'] 			 : null;
		$month          = isset($_args['month']) 		  ? $_args['month'] 		 : null;
		$date_is_shamsi = isset($_args['date_is_shamsi']) ? $_args['date_is_shamsi'] : null;
		$order          = isset($_args['order']) 		  ? $_args['order'] 		 : 'DESC';
		$export  	    = isset($_args['export']) 	 	  ? $_args['export'] 		 : false;

		$query            = null;
		$pagenation_query = null;

		if($user_id)
		{
			// user id is set
			// one person need to get report
			if($month)
			{
				// user id is set
				// one person need to get report
				// month is set
				// one month need to get report
				if($date_is_shamsi)
				{

					// user id is set
					// one person need to get report
					// month is set
					// one month need to get report
					// date is shamsi
					// QUERY ...
					$pagenation_query =
					"
					SELECT COUNT(*) AS `count` FROM
					(
						SELECT 1 FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users     ON users.id = userteams.user_id
						WHERE
							hours.shamsi_year  = '$year' AND
							hours.shamsi_month = '$month' AND
							userteams.id       = $userteam_id
						GROUP BY hours.shamsi_year, hours.shamsi_month
					) AS `count`
					";
					$query =
					"
						SELECT
							hours.shamsi_year                                                           	AS `year`,
							hours.shamsi_month                                                          	AS `month`,
							GROUP_CONCAT(DISTINCT userteams.displayname)                                	AS `displayname`,
							GROUP_CONCAT(DISTINCT userteams.firstname, userteams.lastname SEPARATOR ' ')	AS `name`,
							GROUP_CONCAT(DISTINCT users.mobile)                                    	AS `mobile`,
							COUNT(*)                                                                    	AS `count`,
							userteams.id 																	AS `userteam_id`,
							SUM(hours.diff)                                                             	AS `diff`,
							SUM(hours.minus)                                                            	AS `minus`,
							SUM(hours.plus)                                                             	AS `plus`,
							SUM(hours.accepted)                                                         	AS `accepted`,
							SUM(hours.total)                                                            	AS `total`
						FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users     ON users.id = userteams.user_id
						WHERE
							hours.shamsi_year  = '$year' AND
							hours.shamsi_month = '$month' AND
							userteams.id       = $userteam_id
						GROUP BY hours.shamsi_year, hours.shamsi_month
						LIMIT %d, %d
					";

				}
				else
				{
					// user id is set
					// one person need to get report
					// month is set
					// one month need to get report
					// date is geregorian
					// QUERY ...
					$pagenation_query =
					"
						SELECT COUNT(*) AS `count` FROM
						(
							SELECT 1 FROM
								hours
							INNER JOIN userteams ON userteams.id = hours.userteam_id
							INNER JOIN users     ON users.id = userteams.user_id
							WHERE
								hours.year        = '$year' AND
								hours.month       = '$month' AND
								userteams.id = $userteam_id
							GROUP BY hours.year, hours.month
						) AS `count`
					";
					$query =
					"
						SELECT
							hours.year                                                                  	AS `year`,
							hours.month                                                                 	AS `month`,
							GROUP_CONCAT(DISTINCT userteams.displayname)                                	AS `displayname`,
							GROUP_CONCAT(DISTINCT userteams.firstname, userteams.lastname SEPARATOR ' ')	AS `name`,
							GROUP_CONCAT(DISTINCT users.mobile)                                    	AS `mobile`,
							COUNT(*)                                                                    	AS `count`,
							userteams.id 																	AS `userteam_id`,
							SUM(hours.diff)                                                             	AS `diff`,
							SUM(hours.minus)                                                            	AS `minus`,
							SUM(hours.plus)                                                             	AS `plus`,
							SUM(hours.accepted)                                                         	AS `accepted`,
							SUM(hours.total)                                                            	AS `total`
						FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users     ON users.id = userteams.user_id
						WHERE
							hours.year        = '$year' AND
							hours.month       = '$month' AND
							userteams.id = $userteam_id
						GROUP BY hours.year, hours.month
						LIMIT %d, %d
					";
				}
			}
			else
			{
				// user id is set
				// one person need to get report
				// month is not set
				// all month need to creat report
				if($date_is_shamsi)
				{

					// user id is set
					// one person need to get report
					// month is not set
					// all month need to creat report
					// date is shamsi
					// QUERY ...
					$pagenation_query =
					"
						SELECT COUNT(*) AS `count` FROM
						(
							SELECT 1 FROM
								hours
							INNER JOIN userteams ON userteams.id = hours.userteam_id
							INNER JOIN users     ON users.id = userteams.user_id
							WHERE
								hours.shamsi_year = '$year' AND
								userteams.id      = $userteam_id
							GROUP BY hours.shamsi_year, hours.shamsi_month
						) AS `count`
					";
					$query =
					"
						SELECT
							hours.shamsi_year                                                           	AS `year`,
							hours.shamsi_month                                                          	AS `month`,
							GROUP_CONCAT(DISTINCT userteams.displayname)                                	AS `displayname`,
							GROUP_CONCAT(DISTINCT userteams.firstname, userteams.lastname SEPARATOR ' ')	AS `name`,
							GROUP_CONCAT(DISTINCT users.mobile)                                    	AS `mobile`,
							COUNT(*)                                                                    	AS `count`,
							userteams.id 																	AS `userteam_id`,
							SUM(hours.diff)                                                             	AS `diff`,
							SUM(hours.minus)                                                            	AS `minus`,
							SUM(hours.plus)                                                             	AS `plus`,
							SUM(hours.accepted)                                                         	AS `accepted`,
							SUM(hours.total)                                                            	AS `total`
						FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users     ON users.id = userteams.user_id
						WHERE
							hours.shamsi_year = '$year' AND
							userteams.id      = $userteam_id
						GROUP BY hours.shamsi_year, hours.shamsi_month
						LIMIT %d, %d
					";
				}
				else
				{
					// user id is set
					// one person need to get report
					// month is not set
					// all month need to creat report
					// date is geregorian
					// QUERY ...
					$pagenation_query =
					"
						SELECT COUNT(*) AS `count` FROM
						(
							SELECT
								1
							FROM
								hours
							INNER JOIN userteams ON userteams.id = hours.userteam_id
							INNER JOIN users     ON users.id = userteams.user_id
							WHERE
								hours.year        = '$year' AND
								userteams.id = $userteam_id
							GROUP BY hours.year, hours.month
						) AS `count`
					";
					$query =
					"
						SELECT
							hours.year                                                                  	AS `year`,
							hours.month                                                                 	AS `month`,
							GROUP_CONCAT(DISTINCT userteams.displayname)                                	AS `displayname`,
							GROUP_CONCAT(DISTINCT userteams.firstname, userteams.lastname SEPARATOR ' ')	AS `name`,
							GROUP_CONCAT(DISTINCT users.mobile)                                    	AS `mobile`,
							COUNT(*)                                                                    	AS `count`,
							userteams.id 																	AS `userteam_id`,
							SUM(hours.diff)                                                             	AS `diff`,
							SUM(hours.minus)                                                            	AS `minus`,
							SUM(hours.plus)                                                             	AS `plus`,
							SUM(hours.accepted)                                                         	AS `accepted`,
							SUM(hours.total)                                                            	AS `total`
						FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users     ON users.id = userteams.user_id
						WHERE
							hours.year        = '$year' AND
							userteams.id = $userteam_id
						GROUP BY hours.year, hours.month
						LIMIT %d, %d
					";
				}
			}
		}
		else
		{
			// user id is not set
			// all user must be show
			if($month)
			{
				// user id is not set
				// all person need to get report
				// month is set
				// one month need to get report
				if($date_is_shamsi)
				{
					// user id is not set
					// all person need to get report
					// month is set
					// one month need to get report
					// date is shamsi
					// QUERY ...
					$pagenation_query =
					"
						SELECT COUNT(*) AS `count` FROM
						(
							SELECT
								1
							FROM
								hours
							INNER JOIN userteams ON userteams.id = hours.userteam_id
							INNER JOIN users     ON users.id = userteams.user_id
							WHERE
								hours.shamsi_year  = '$year' AND
								hours.shamsi_month = '$month' AND
								userteams.team_id = $team_id
							GROUP BY hours.shamsi_year, hours.shamsi_month, userteams.user_id
						) AS `count`
					";
					$query =
					"
						SELECT
							hours.shamsi_year                                                           	AS `year`,
							hours.shamsi_month                                                          	AS `month`,
							GROUP_CONCAT(DISTINCT userteams.displayname)                                	AS `displayname`,
							GROUP_CONCAT(DISTINCT userteams.firstname, userteams.lastname SEPARATOR ' ')	AS `name`,
							GROUP_CONCAT(DISTINCT users.mobile)                                    	AS `mobile`,
							COUNT(*)                                                                    	AS `count`,
							userteams.id 																	AS `userteam_id`,
							SUM(hours.diff)                                                             	AS `diff`,
							SUM(hours.minus)                                                            	AS `minus`,
							SUM(hours.plus)                                                             	AS `plus`,
							SUM(hours.accepted)                                                         	AS `accepted`,
							SUM(hours.total)                                                            	AS `total`
						FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users     ON users.id = userteams.user_id
						WHERE
							hours.shamsi_year  = '$year' AND
							hours.shamsi_month = '$month' AND
							userteams.team_id = $team_id
						GROUP BY hours.shamsi_year, hours.shamsi_month, userteams.user_id
						LIMIT %d, %d
					";
				}
				else
				{
					// user id is not set
					// all person need to get report
					// month is set
					// one month need to get report
					// date is geregorian
					// QUERY ...
					$pagenation_query =
					"
						SELECT COUNT(*) AS `count` FROM
						(
							SELECT
								1
							FROM
								hours
							INNER JOIN userteams ON userteams.id = hours.userteam_id
							INNER JOIN users     ON users.id = userteams.user_id
							WHERE
								hours.year  = '$year' AND
								hours.month = '$month' AND
								userteams.team_id = $team_id
							GROUP BY hours.year, hours.month, userteams.user_id
						) AS `count`

					";
					$query =
					"
						SELECT
							hours.year                                                                  	AS `year`,
							hours.month                                                                 	AS `month`,
							GROUP_CONCAT(DISTINCT userteams.displayname)                                	AS `displayname`,
							GROUP_CONCAT(DISTINCT userteams.firstname, userteams.lastname SEPARATOR ' ')	AS `name`,
							GROUP_CONCAT(DISTINCT users.mobile)                                    	AS `mobile`,
							COUNT(*)                                                                    	AS `count`,
							userteams.id 																	AS `userteam_id`,
							SUM(hours.diff)                                                             	AS `diff`,
							SUM(hours.minus)                                                            	AS `minus`,
							SUM(hours.plus)                                                             	AS `plus`,
							SUM(hours.accepted)                                                         	AS `accepted`,
							SUM(hours.total)                                                            	AS `total`
						FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users     ON users.id = userteams.user_id
						WHERE
							hours.year  = '$year' AND
							hours.month = '$month' AND
							userteams.team_id = $team_id
						GROUP BY hours.year, hours.month, userteams.user_id
						LIMIT %d, %d
					";
				}
			}
			else
			{
				// user id is not set
				// all person need to get report
				// month is not set
				// all month need to creat report
				if($date_is_shamsi)
				{
					// user id is not set
					// all person need to get report
					// month is not set
					// all month need to creat report
					// date is shamsi
					// QUERY ...
					$pagenation_query =
					"
					SELECT COUNT(*) AS `count` FROM
					(
						SELECT 1 FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users     ON users.id = userteams.user_id
						WHERE
							hours.shamsi_year  = '$year' AND
							userteams.team_id = $team_id
						GROUP BY hours.shamsi_year, hours.shamsi_month, userteams.user_id
					) AS `count`
					";
					$query =
					"
						SELECT
							hours.shamsi_year                                                           	AS `year`,
							hours.shamsi_month                                                          	AS `month`,
							GROUP_CONCAT(DISTINCT userteams.displayname)                                	AS `displayname`,
							GROUP_CONCAT(DISTINCT userteams.firstname, userteams.lastname SEPARATOR ' ')	AS `name`,
							GROUP_CONCAT(DISTINCT users.mobile)                                    	AS `mobile`,
							COUNT(*)                                                                    	AS `count`,
							userteams.id 																	AS `userteam_id`,
							SUM(hours.diff)                                                             	AS `diff`,
							SUM(hours.minus)                                                            	AS `minus`,
							SUM(hours.plus)                                                             	AS `plus`,
							SUM(hours.accepted)                                                         	AS `accepted`,
							SUM(hours.total)                                                            	AS `total`
						FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users     ON users.id = userteams.user_id
						WHERE
							hours.shamsi_year  = '$year' AND
							userteams.team_id = $team_id
						GROUP BY hours.shamsi_year, hours.shamsi_month, userteams.user_id
						LIMIT %d, %d
					";

				}
				else
				{
					// user id is not set
					// all person need to get report
					// month is not set
					// all month need to creat report
					// date is geregorian
					// QUERY ...
					$pagenation_query =
					"
					SELECT COUNT(*) AS `count` FROM
					(
						SELECT 1 FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users     ON users.id = userteams.user_id
						WHERE
							hours.year  = '$year' AND
							userteams.team_id = $team_id
						GROUP BY hours.year, hours.month, userteams.user_id
					) AS `count`

					";
					$query =
					"
						SELECT
							hours.year                                                                  	AS `year`,
							hours.month                                                                 	AS `month`,
							GROUP_CONCAT(DISTINCT userteams.displayname)                                	AS `displayname`,
							GROUP_CONCAT(DISTINCT userteams.firstname, userteams.lastname SEPARATOR ' ')	AS `name`,
							GROUP_CONCAT(DISTINCT users.mobile)                                    	AS `mobile`,
							COUNT(*)                                                                    	AS `count`,
							userteams.id 																	AS `userteam_id`,
							SUM(hours.diff)                                                             	AS `diff`,
							SUM(hours.minus)                                                            	AS `minus`,
							SUM(hours.plus)                                                             	AS `plus`,
							SUM(hours.accepted)                                                         	AS `accepted`,
							SUM(hours.total)                                                            	AS `total`
						FROM
							hours
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						INNER JOIN users     ON users.id = userteams.user_id
						WHERE
							hours.year  = '$year' AND
							userteams.team_id = $team_id
						GROUP BY hours.year, hours.month, userteams.user_id
						LIMIT %d, %d
					";
				}
			}

		}

		$result = [];
		if($query && $pagenation_query)
		{
			$count_record              = \dash\db::get($pagenation_query, 'count', true);
			list($limit_start, $limit) = \dash\db::pagnation((int) $count_record, 10);
			$query                     = sprintf($query, $limit_start, $limit);

			if($export)
			{
				$query  = preg_replace("/LIMIT \d+\, \d+/", '', $query);
			}

			$result = \dash\db::get($query);
		}
		return $result;
	}
}
?>