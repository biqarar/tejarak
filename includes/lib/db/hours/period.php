<?php
namespace lib\db\hours;

trait period
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
	 * result as sum time in month
	 *
	 * @param      array  $_args  The arguments
	 */
	public static function sum_period_time($_args = [])
	{
		$team_id        = isset($_args['team_id']) 		  ? $_args['team_id'] 		 : null;
		$user_id        = isset($_args['user_id']) 		  ? $_args['user_id'] 		 : null;
		$userteam_id    = isset($_args['userteam_id']) 	  ? $_args['userteam_id'] 	 : null;
		$start          = isset($_args['start']) 		  ? $_args['start'] 		 : null;
		$end            = isset($_args['end']) 		 	  ? $_args['end'] 			 : null;
		$date_is_shamsi = isset($_args['date_is_shamsi']) ? $_args['date_is_shamsi'] : null;
		$order          = isset($_args['order']) 		  ? $_args['order'] 		 : 'DESC';
		$export   	    = isset($_args['export']) 	 	  ? $_args['export'] 		 : false;

		$query            = null;
		$pagenation_query = null;

		if($user_id)
		{
			// user id is set
			// one person need to get report
			if($date_is_shamsi)
			{
				// user id is set
				// one person need to get report
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
							hours.shamsi_date  >= '$start' AND
							hours.shamsi_date  <= '$end' AND
							userteams.id       = $userteam_id
						GROUP BY userteams.id
					) AS `count`
				";
				$query =
				"
					SELECT
						'$start'                                                                    	AS `start`,
						'$end'                                                                       	AS `end`,
						GROUP_CONCAT(DISTINCT userteams.displayname)                                	AS `displayname`,
						GROUP_CONCAT(DISTINCT userteams.firstname, userteams.lastname SEPARATOR ' ')	AS `name`,
						GROUP_CONCAT(DISTINCT users.user_mobile)                                    	AS `mobile`,
						COUNT(*)                                                                    	AS `count`,
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
						hours.shamsi_date  >= '$start' AND
						hours.shamsi_date  <= '$end' AND
						userteams.id       = $userteam_id
					GROUP BY userteams.id
					LIMIT %d, %d
				";
			}
			else
			{
				// user id is set
				// one person need to get report
				// date is gregorian
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
							hours.date  >= '$start' AND
							hours.date  <= '$end' AND
							userteams.id       = $userteam_id
						GROUP BY userteams.id
					) AS `count`
				";
				$query =
				"
					SELECT
						'$start'                                                                    	AS `start`,
						'$end'                                                                       	AS `end`,
						GROUP_CONCAT(DISTINCT userteams.displayname)                                	AS `displayname`,
						GROUP_CONCAT(DISTINCT userteams.firstname, userteams.lastname SEPARATOR ' ')	AS `name`,
						GROUP_CONCAT(DISTINCT users.user_mobile)                                    	AS `mobile`,
						COUNT(*)                                                                    	AS `count`,
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
						hours.date  >= '$start' AND
						hours.date  <= '$end' AND
						userteams.id       = $userteam_id
					GROUP BY userteams.id
					LIMIT %d, %d
				";
			}
		}
		else
		{
			// user id is not set
			// all person need to get report
			if($date_is_shamsi)
			{
				// user id is not set
				// all person need to get report
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
							hours.shamsi_date  >= '$start' AND
							hours.shamsi_date  <= '$end' AND
							userteams.team_id = $team_id
						GROUP BY userteams.id
					) AS `count`
				";
				$query =
				"
					SELECT
						'$start'                                                                    	AS `start`,
						'$end'                                                                       	AS `end`,
						GROUP_CONCAT(DISTINCT userteams.displayname)                                	AS `displayname`,
						GROUP_CONCAT(DISTINCT userteams.firstname, userteams.lastname SEPARATOR ' ')	AS `name`,
						GROUP_CONCAT(DISTINCT users.user_mobile)                                    	AS `mobile`,
						COUNT(*)                                                                    	AS `count`,
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
						hours.shamsi_date  >= '$start' AND
						hours.shamsi_date  <= '$end' AND
						userteams.team_id = $team_id
					GROUP BY userteams.id
					LIMIT %d, %d
				";
			}
			else
			{
				// user id is not set
				// all person need to get report
				// date is gregorian
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
							hours.date  >= '$start' AND
							hours.date  <= '$end' AND
							userteams.team_id = $team_id
						GROUP BY userteams.id
					) AS `count`
				";
				$query =
				"
					SELECT
						'$start'                                                                    	AS `start`,
						'$end'                                                                       	AS `end`,
						GROUP_CONCAT(DISTINCT userteams.displayname)                                	AS `displayname`,
						GROUP_CONCAT(DISTINCT userteams.firstname, userteams.lastname SEPARATOR ' ')	AS `name`,
						GROUP_CONCAT(DISTINCT users.user_mobile)                                    	AS `mobile`,
						COUNT(*)                                                                    	AS `count`,
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
						hours.date  >= '$start' AND
						hours.date  <= '$end' AND
						userteams.team_id = $team_id
					GROUP BY userteams.id
					LIMIT %d, %d
				";
			}
		}

		$result = [];
		if($query && $pagenation_query)
		{
			$count_record              = \lib\db::get($pagenation_query, 'count', true);
			list($limit_start, $limit) = \lib\db::pagnation((int) $count_record, 10);
			$query                     = sprintf($query, $limit_start, $limit);
			if($export)
			{
				$query  = preg_replace("/LIMIT \d+\, \d+/", '', $query);
			}
			$result = \lib\db::get($query);
		}
		return $result;
	}
}
?>