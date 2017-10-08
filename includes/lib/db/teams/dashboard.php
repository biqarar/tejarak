<?php
namespace lib\db\teams;

trait dashboard
{
	/**
	 * { function_description }
	 *
	 * @param      <type>  $_team_id  The team identifier
	 */
	public static function dashboard_detail($_team_id, $_user_id)
	{
		if(!$_team_id || !is_numeric($_team_id) || !$_user_id || !is_numeric($_user_id))
		{
			return false;
		}

		$result = [];

		$userteam_detail = \lib\db\userteams::get(['user_id' => $_user_id, 'team_id' =>$_team_id, 'limit' => 1]);

		if(isset($userteam_detail['rule']) && $userteam_detail['rule'] === 'admin')
		{
			$is_admin = true;
		}
		else
		{
			$is_admin = false;
		}

		$static_number = self::count_detail([$_team_id], false, $is_admin ? null : $_user_id);
		if(isset($static_number[$_team_id]))
		{
			$static_number = $static_number[$_team_id];
		}

		if(is_array($static_number))
		{
			$result = array_merge($result, $static_number);
		}

		$result['hour_count']      = self::hour_count($_team_id, $is_admin ? null : $_user_id);
		$result['count_day_work']  = self::count_day_work($_team_id, $is_admin ? null : $_user_id);
		$result['member_present']  = count(self::get_active_member($_team_id));
		$result['last_time_chart'] = self::last_time_chart($_team_id, $is_admin ? null : $_user_id);

		if(isset($result['member_count']))
		{
			$myDivision = intval($result['member_count']);
		}
		else
		{
			$myDivision = 1;
		}

		$result['member_percent']  = (intval($result['member_present']) * 100) / $myDivision;

		return $result;
	}


	/**
	 * last time chart
	 *
	 * @param      <type>  $_team_id  The team identifier
	 */
	public static function last_time_chart($_team_id, $_user_id = null)
	{
		$now = date("Y-m-d");
		$last_10_day = date("Y-m-d", strtotime("-10 day"));

		$user_id = null;
		if($_user_id)
		{
			$user_id = " AND hours.userteam_id IN (SELECT id FROM userteams WHERE userteams.id = hours.userteam_id AND userteams.user_id = $_user_id) ";
		}
		$query =
		"
			SELECT
				SUM(hours.total) AS `total`,
				hours.date
			FROM
				hours
			WHERE
				hours.team_id       = $_team_id AND
				DATE(hours.enddate) >= DATE('$last_10_day')
				$user_id
			GROUP BY
				hours.date

		";

		$result = \lib\db::get($query, ['date', 'total']);

		if(is_array($result))
		{
			$temp = [];
			for ($i = 0; $i < 10 ; $i++)
			{
				$key = date("Y-m-d", strtotime("-$i day"));
				if(isset($result[$key]))
				{
					$temp[$key] = $result[$key];
				}
				else
				{
					$temp[$key] = 0;
				}
			}
			$result = $temp;
		}

		return $result;
	}



	/**
	 * sum hour working
	 *
	 * @param      <type>  $_team_id  The team identifier
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function hour_count($_team_id, $_user_id = null)
	{
		$user_id = null;
		if($_user_id)
		{
			$user_id = " AND hours.userteam_id IN (SELECT id FROM userteams WHERE userteams.id = hours.userteam_id AND userteams.user_id = $_user_id ) ";
		}
		$query =
		"
			SELECT
				SUM(hours.total) AS `total`
			FROM
				hours
			WHERE
				hours.userteam_id IN (SELECT id FROM userteams WHERE userteams.team_id = $_team_id)
				$user_id
			";
		$result = \lib\db::get($query, 'total', true);
		return $result;
	}


	/**
	 * { function_description }
	 *
	 * @param      <type>  $_team_id  The team identifier
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function count_day_work($_team_id, $_user_id = null)
	{
		$user_id = null;
		if($_user_id)
		{
			$user_id = " AND hours.userteam_id IN (SELECT id FROM userteams WHERE userteams.id = hours.userteam_id AND userteams.user_id = $_user_id ) ";
		}
		$query =
		"
			SELECT
				COUNT(*) AS `count`
			FROM
				hours
			WHERE
				hours.userteam_id IN (SELECT id FROM userteams WHERE userteams.team_id = $_team_id)
				$user_id
			GROUP BY hours.date";
		$result = \lib\db::get($query, 'count', true);
		$result = count($result);
		return $result;
	}


}
?>