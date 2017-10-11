<?php
namespace lib\db;
use \lib\db;
use \lib\debug;
use \lib\utility;

class hourrequests
{
	public static $public_field =
	"
		userteams.displayname,
		hourrequests.*
	";


	/**
	 * insert new record in hourrequests table
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		return db\config::public_insert('hourrequests', ...func_get_args());
	}


	/**
	 * get
	 *
	 * @param      <type>  $_where  The where
	 */
	public static function get()
	{
		return db\config::public_get('hourrequests', ...func_get_args());
	}


	/**
	 * update
	 *
	 * @param      <type>  $_where  The where
	 */
	public static function update()
	{
		return db\config::public_update('hourrequests', ...func_get_args());
	}



	/**
	 * Searches for the first match.
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function search($_search = null, $_option = [])
	{
		if(!is_array($_option))
		{
			$_option = [];
		}

		$default_option =
		[
			'public_show_field' => self::$public_field,
			'master_join'       => "LEFT JOIN userteams ON hourrequests.userteam_id = userteams.id",
			// 'search_field'      =>
			// "
			// 	(
			// 	 	users.displayname 	LIKE '%__string__%' OR
			// 	 	users.birthday 		LIKE '%__string__%' OR
			// 	 	users.nationalcode 	LIKE '%__string__%' OR
			// 	 	users.father 		LIKE '%__string__%' OR
			// 	 	users.mobile 		LIKE '%__string__%'
			// 	)
			// ",
		];

		$_option = array_merge($default_option, $_option);

		$result = \lib\db\config::public_search('hourrequests', $_search, $_option);


		return $result;
	}


	/**
	 * check access to load hourrequest
	 *
	 * @param      <type>  $_id       The identifier
	 * @param      <type>  $_user_id  The user identifier
	 * @param      array   $_option   The option
	 */
	public static function access_hourrequest_id($_id, $_user_id, $_option = [])
	{
		if(!$_id || !is_numeric($_id) || !$_user_id || !is_numeric($_user_id))
		{
			return false;
		}

		$result = null;

		if(isset($_option['action']))
		{
			switch ($_option['action'])
			{
				case 'view':
					$query =
					"
						SELECT
							hourrequests.*
						FROM
							hourrequests
						INNER JOIN hours ON hours.id = hourrequests.hour_id
						INNER JOIN userteams ON userteams.id = hours.userteam_id
						WHERE
							userteams.user_id    = $_user_id AND
							hourrequests.hour_id = $_id 	 AND
							hourrequests.status <> 'deleted'
						LIMIT 1
					";
					$result = \lib\db::get($query, null, true);
					break;

				// only awaiting request can delete
				case 'delete':
					$query =
					"
						SELECT
							hourrequests.*
						FROM
							hourrequests
						WHERE
							hourrequests.creator = $_user_id AND
							hourrequests.id      = $_id  	 AND
							hourrequests.status  = 'awaiting'
						LIMIT 1
					";
					$result = \lib\db::get($query, null, true);
					break;
				default:
					return false;
					break;
			}

			return $result;
		}
		else
		{
			return false;
		}

	}
}
?>