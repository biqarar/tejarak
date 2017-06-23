<?php
namespace lib\db;
use \lib\db;

class userteams
{

	/**
	 * get total of userteam
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function total_count()
	{
		return intval(\lib\db::get("SELECT COUNT(*) AS `count` FROM userteams", 'count', true));
	}


	/**
	 * get total userteam and save in file
	 * to show in footer
	 *
	 * @return     integer  ( description_of_the_return_value )
	 */
	public static function total_userteam()
	{
		$result = 0;
		$url    = root. 'public_html/files/data/';
		if(!\lib\utility\file::exists($url))
		{
			\lib\utility\file::makeDir($url, null, true);
		}
		$url .= 'total_userteam.txt';
		if(!\lib\utility\file::exists($url))
		{
			$result = self::total_count();
			\lib\utility\file::write($url, $result);
		}
		else
		{
			$file_time = \filemtime($url);
			if((time() - $file_time) >  (60 * 10))
			{
				$result       = self::total_count();
				\lib\utility\file::write($url, $result);
			}
			else
			{
				$result = \lib\utility\file::read($url);
			}
		}
		return $result;
	}

	/**
	 * add new userteam
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\lib\db\config::public_insert('userteams', ...func_get_args());
		return \lib\db::insert_id();
	}


	/**
	 * Gets the identifier.
	 *
	 * @param      <type>  $_where  The where
	 *
	 * @return     <type>  The identifier.
	 */
	public static function get_id($_where)
	{
		$_where['limit'] = 1;
		$id              =  \lib\db\config::public_get('userteams', $_where);
		if(isset($id['id']))
		{
			return $id['id'];
		}
		return false;
	}


	/**
	 * get userteam record
	 *
	 * @param      <type>  $_id    The identifier
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get($_args)
	{
		if($_args)
		{

			$only_one_value = false;
			$limit          = null;

			if(isset($_args['limit']))
			{
				if($_args['limit'] === 1)
				{
					$only_one_value = true;
				}

				$limit = " LIMIT $_args[limit] ";
			}
			$get_hours = false;
			if(isset($_args['get_hours']) && $_args['get_hours'])
			{
				$get_hours = true;
			}

			unset($_args['limit']);
			unset($_args['get_hours']);

			$where = \lib\db\config::make_where($_args, ['table_name' => 'userteams']);

			$date = date("Y-m-d");

			if($get_hours)
			{
				$query =
				"
					SELECT
						userteams.*,
						users.user_mobile AS `mobile`,
						hours.start AS `last_time`,
						hours.plus AS `plus`
					FROM
						userteams
					LEFT JOIN users ON users.id = userteams.user_id
					LEFT JOIN hours ON hours.userteam_id = userteams.id AND (IF(userteams.24h, hours.date = '$date', TRUE) AND hours.end IS NULL)
					WHERE
						$where
					ORDER BY userteams.sort, userteams.id ASC
					$limit
				";
			}
			else
			{
				$query =
				"
					SELECT
						userteams.*,
						users.user_mobile AS `mobile`
					FROM
						userteams
					LEFT JOIN users ON users.id = userteams.user_id
					WHERE
						$where
					ORDER BY userteams.sort, userteams.id ASC
					$limit
				";
			}
			$result = \lib\db::get($query, null, $only_one_value);
			return $result;
		}
		return false;
	}



	/**
	 * get userteam record
	 *
	 * @param      <type>  $_id    The identifier
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get_by_id($_userteams_id)
	{
		if($_userteams_id)
		{
			$query =
			"
				SELECT
					userteams.*,
					users.user_mobile AS `mobile`,
					users.user_displayname AS `displayname`,
					users.user_email AS `email`
				FROM
					userteams
				INNER JOIN users ON users.id = userteams.user_id
				INNER JOIN teams ON teams.id = userteams.team_id
				WHERE
					userteams.id = $_userteams_id
				LIMIT 1
			";
			$result = \lib\db::get($query, null, true);
			return $result;
		}
		return false;
	}



	/**
	 * remove
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function remove($_args)
	{
		if(isset($_args['team_id']) && isset($_args['user_id']) && is_numeric($_args['team_id']) && is_numeric($_args['user_id']))
		{
			$query =
			"
				DELETE FROM userteams
				WHERE
					userteams.team_id = $_args[team_id] AND
					userteams.user_id = $_args[user_id]
				LIMIT 1
			";
			$result = \lib\db::get($query, null, true);
			return $result;

		}
	}


	/**
	 * update userteam
	 *
	 * @param      <type>  $_args  The arguments
	 * @param      <type>  $_id    The identifier
	 */
	public static function update()
	{
		return \lib\db\config::public_update('userteams', ...func_get_args());
	}


	/**
	 * Searches for the first match.
	 *
	 * @param      <type>  $_string   The string
	 * @param      array   $_options  The options
	 */
	public static function search()
	{
		return \lib\db\config::public_search('userteams', ...func_get_args());
	}

}
?>