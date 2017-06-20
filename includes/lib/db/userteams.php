<?php
namespace lib\db;
use \lib\db;

class userteams
{

	/**
	 * add new userteam
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert($_args)
	{
		$set = \lib\db\config::make_set($_args);
		if($set)
		{
			\lib\db::query("INSERT INTO userteams SET $set");
			return \lib\db::insert_id();
		}
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

			unset($_args['limit']);
			$where = \lib\db\config::make_where($_args);
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
				WHERE
					$where
				$limit
			";
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
	public static function get_by_id($_userteams_id, $_boss)
	{
		if($_userteams_id && $_boss)
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
					userteams.id = $_userteams_id AND teams.boss = $_boss
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
	public static function update($_args, $_id)
	{
		$set = \lib\db\config::make_set($_args);
		if(!$set || !$_id || !is_numeric($_id))
		{
			return false;
		}

		$query = "UPDATE userteams SET $set WHERE id = $_id LIMIT 1";
		return \lib\db::query($query);
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