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

		$static_number = self::count_detail([$_team_id]);
		if(isset($static_number[$_team_id]))
		{
			$static_number = $static_number[$_team_id];
		}

		if(is_array($static_number))
		{
			$result = array_merge($result, $static_number);
		}

		$result['hour_count']      = self::hour_count($_team_id);
		$result['count_day_work']  = self::count_day_work($_team_id);
		$result['member_present']  = count(self::get_active_member($_team_id));
		$result['last_time_chart'] = self::last_time_chart($_team_id);

		return $result;
	}


	/**
	 * last time chart
	 *
	 * @param      <type>  $_team_id  The team identifier
	 */
	public static function last_time_chart($_team_id)
	{
		$now = date("Y-m-d");
		$last_10_day = date("Y-m-d", strtotime("-10 day"));

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
	public static function hour_count($_team_id)
	{
		$query = "SELECT SUM(hours.total) AS `total` FROM hours WHERE hours.team_id = $_team_id ";
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
	public static function count_day_work($_team_id)
	{
		$query = "SELECT COUNT(*) AS `count`  FROM hours WHERE hours.team_id = $_team_id GROUP BY hours.date";
		$result = \lib\db::get($query, 'count', true);
		$result = count($result);
		return $result;
	}


}
?>