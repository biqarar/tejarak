<?php
namespace lib\db;
use \lib\db;

class userteams
{
	/**
	 * update all user id in parent and child of this team
	 * if the team is school
	 * update all user id in lesson of this team
	 * if the team is lesson
	 * update all user id in school
	 *
	 * @param      <type>  $_old_user_id  The old user identifier
	 * @param      <type>  $_new_user_id  The new user identifier
	 * @param      <type>  $_team_id      The team identifier
	 * @param      <type>  $_log_meta     The log meta
	 */
	public static function update_all_user_id($_old_user_id, $_new_user_id, $_team_id, $_log_meta = [])
	{
		$log_meta                 = $_log_meta;
		$log_meta['meta']['func'] = func_get_args();

		if(!is_numeric($_old_user_id) || !is_numeric($_new_user_id) || !$_old_user_id || !$_new_user_id)
		{
			return false;
		}

		$ids   = [];
		$ids[] = $_team_id;

		$parent = self::get_parent($_team_id);
		$ids[]  = $parent;
		while ($parent)
		{
			$parent = self::get_parent($parent);
			$ids[]  = $parent;
		}

		$child = self::get_child($_team_id);
		$ids[] = $child;
		while ($child)
		{
			$child = self::get_child($child);
			$ids[] = $child;
		}

		$ids = array_filter($ids);
		$ids = array_unique($ids);

		$ids = array_map(function($_a){return intval($_a);}, $ids);

		if(!empty($ids))
		{
			$all_team_id = implode(',', $ids);
			$check_duplicate =  "SELECT userteams.id, userteams.type FROM userteams WHERE userteams.user_id = $_new_user_id AND userteams.team_id IN ($all_team_id) ";
			$check_duplicate = \lib\db::get($check_duplicate);
			if($check_duplicate)
			{
				\lib\db\logs::set('change:all:user:id:team:duplicate', null, $log_meta);
				\lib\debug::error(T_("This already exist in this team, can not add again"));
				return false;
			}
			$query = "UPDATE userteams SET userteams.user_id = $_new_user_id WHERE userteams.user_id = $_old_user_id AND userteams.team_id IN ($all_team_id) ";
			\lib\db::query($query);
		}
	}


	/**
	 * Gets the parent of team
	 *
	 * @param      <type>   $_team_id  The team identifier
	 *
	 * @return     boolean  The parent.
	 */
	public static function get_parent($_team_id)
	{
		if(!is_numeric($_team_id) || !$_team_id)
		{
			return false;
		}

		$query = "SELECT teams.parent AS `parent` FROM teams WHERE teams.id = $_team_id LIMIT 1";
		$result = \lib\db::get($query, 'parent', true);
		return $result;
	}


	/**
	 * Gets the child of team
	 *
	 * @param      <type>   $_team_id  The team identifier
	 *
	 * @return     boolean  The child.
	 */
	public static function get_child($_team_id)
	{
		if(!is_numeric($_team_id) || !$_team_id)
		{
			return false;
		}

		$query = "SELECT teams.id AS `id` FROM teams WHERE teams.parent = $_team_id LIMIT 1";
		$result = \lib\db::get($query, 'id', true);
		return $result;
	}


	/**
	 * Gets the admins.
	 *
	 * @param      <type>   $_args  The arguments
	 *
	 * @return     boolean  The admins.
	 */
	public static function get_admins($_args)
	{
		if(!isset($_args['id']))
		{
			return false;
		}
		$team_id = \lib\utility\shortURL::decode($_args['id']);

		if(!$team_id || !is_numeric($team_id))
		{
			return false;
		}
		$query =
		"
			SELECT
				displayname,
				id,
				reportdaily AS `daily`,
				reportenterexit AS `enterexit`
			FROM
				userteams
			WHERE
				team_id = $team_id AND
				rule    = 'admin'
		";
		$result = \lib\db::get($query);
		if(is_array($result))
		{
			// encode id of userteam
			$result = array_map(
			function($_a)
			{
				if(isset($_a['id']))
				{
					$_a['id'] = \lib\utility\shortURL::encode($_a['id']);
				}
				if(array_key_exists('daily', $_a))
				{
					if($_a['daily'])
					{
						$_a['daily'] = true;
					}
					else
					{
						$_a['daily'] = false;
					}
				}

				if(array_key_exists('enterexit', $_a))
				{
					if($_a['enterexit'])
					{
						$_a['enterexit'] = true;
					}
					else
					{
						$_a['enterexit'] = false;
					}
				}
				return $_a;

			}, $result);
		}

		return $result;
	}


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
	 * hours
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		return \lib\db\config::public_get('userteams', ...func_get_args());
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
	 * if the user change the team shortnam
	 * and this team have gateway
	 * the gateway useranme must be change
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function gateway_username_fix($_args)
	{
		$default_args =
		[
			'old_shortname' => null,
			'new_shortname' => null,
			'team_id'       => null,
		];

		if(is_array($_args))
		{
			$_args = array_merge($default_args, $_args);
		}

		if(!$_args['old_shortname'] || !$_args['new_shortname'] || !$_args['team_id'])
		{
			return false;
		}

		$query =
		"
			UPDATE
				users
			SET
				users.user_username = REPLACE(users.user_username, '$_args[old_shortname]', '$_args[new_shortname]')
			WHERE
				users.id IN
				(
					SELECT
						userteams.user_id
					FROM
						userteams
					WHERE
						userteams.team_id = $_args[team_id] AND
						userteams.rule = 'gateway'
				)
		";
		\lib\db::query($query);
	}


	/**
	 * get userteam record
	 *
	 * @param      <type>  $_id    The identifier
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get_list($_args)
	{
		if($_args)
		{

			$only_one_value = false;
			$limit          = null;
			$search_query = null;

			if(isset($_args['search']))
			{
				$search_query =
				"
				 	AND
				 	(
				 		userteams.displayname LIKE '%$_args[search]%' OR
				 		userteams.nationalcode LIKE '%$_args[search]%' OR
				 		users.user_mobile LIKE '%$_args[search]%'
				 	)
				";
			}

			unset($_args['search']);

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
				// $query =
				// "
				// 	SELECT
				// 		userteams.*,
				// 		users.user_mobile AS `mobile`,
				// 		users.user_username AS `username`,
				// 		(
				// 			SELECT
				// 				CONCAT(hours.date, ' ', hours.start)
				// 			FROM
				// 				hours
				// 			WHERE
				// 				hours.userteam_id = userteams.id AND
				// 				IF(userteams.24h = 0 OR userteams.24h IS NULL , hours.date = '$date', hours.id = (SELECT MAX(hours.id) FROM hours WHERE hours.userteam_id = userteams.id)) AND
				// 				hours.end IS NULL
				// 			ORDER BY hours.id DESC
				// 			LIMIT 1
				// 		) AS `last_time`

				// 	FROM
				// 		userteams
				// 	LEFT JOIN users ON users.id = userteams.user_id

				// 	WHERE
				// 		$where
				// 	ORDER BY userteams.sort, userteams.id ASC
				// 	$limit
				// ";

				$query =
				"
					SELECT
						userteams.*,
						hours.date,
						hours.start,
						hours.end,
						hours.minus,
						hours.plus,
						hours.enddate
					FROM
						userteams
					LEFT JOIN hours ON hours.id = (SELECT hours.id FROM hours WHERE hours.userteam_id = userteams.id ORDER BY hours.id DESC LIMIT 1)
					LEFT JOIN users ON users.id = userteams.user_id
					WHERE
						$where
						$search_query
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
						users.user_username AS `username`,
						users.user_mobile AS `mobile`
					FROM
						userteams
					LEFT JOIN users ON users.id = userteams.user_id
					WHERE
						$where
						$search_query
					ORDER BY userteams.sort, userteams.id ASC
					$limit
				";
			}
			$result = \lib\db::get($query, null, $only_one_value);
			// var_dump($result);exit();
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
	public static function search($_string = null, $_options = [])
	{
		if(!is_array($_options))
		{
			$_options = [];
		}

		$default_option =
		[
			'search_field' => "( userteams.displayname LIKE '%__string__%' ) ",
		];

		$_options = array_merge($default_option, $_options);
		return \lib\db\config::public_search('userteams', $_string, $_options);
	}

}
?>