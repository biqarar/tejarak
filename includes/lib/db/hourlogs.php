<?php
namespace lib\db;
use \lib\db;

class hourlogs
{
	/**
	 * get the hourlogs
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		return db\config::public_get('hourlogs', ...func_get_args());
	}

	/**
	 * Searches for the first match.
	 *
	 * @param      <type>  $_string   The string
	 * @param      array   $_options  The options
	 */
	public static function search($_string = null, $_options = [])
	{
		$where = []; // conditions

		if(!$_string && empty($_options))
		{
			// default return of this function 10 last record of search
			$_options['get_last'] = true;
		}

		$default_options =
		[
			// just return the count record
			"get_count"      => false,
			// enable|disable paignation,
			"pagenation"     => true,
			// for example in get_count mode we needless to limit and pagenation
			// default limit of record is 15
			// set the limit = null and pagenation = false to get all record whitout limit
			"limit"          => 15,
			// for manual pagenation set the statrt_limit and end limit
			"start_limit"    => 0,
			// for manual pagenation set the statrt_limit and end limit
			"end_limit"      => 10,
			// the the last record inserted to post table
			"get_last"       => false,
			// default order by DESC you can change to DESC
			"order"          => "DESC",
			// custom sort by field
			"sort"           => null,
		];

		$_options = array_merge($default_options, $_options);

		$pagenation = false;
		if($_options['pagenation'])
		{
			// page nation
			$pagenation = true;
		}

		// ------------------ get count
		$only_one_value = false;
		$get_count      = false;

		if($_options['get_count'] === true)
		{
			$get_count      = true;
			$public_fields  = " COUNT(*) AS 'searchcount' FROM	`hourlogs` INNER JOIN userteams ON userteams.id = hourlogs.userteam_id";
			$limit          = null;
			$only_one_value = true;
		}
		else
		{
			$limit         = null;
			$public_fields =
			" hourlogs.*, userteams.*, hourlogs.id AS `hour_id` FROM `hourlogs`
			INNER JOIN userteams ON userteams.id = hourlogs.userteam_id
			";

			if($_options['limit'])
			{
				$limit = $_options['limit'];
			}
		}


		if($_options['sort'])
		{
			$temp_sort = null;
			switch ($_options['sort'])
			{
				default:
					$temp_sort = $_options['sort'];
					break;
			}
			$_options['sort'] = $temp_sort;
		}

		// ------------------ get last
		$order = null;
		if($_options['get_last'])
		{
			if($_options['sort'])
			{
				$order = " ORDER BY hourlogs.$_options[sort] $_options[order] ";
			}
			else
			{
				$order = " ORDER BY `hourlogs`.`id` DESC ";
			}
		}
		else
		{
			if($_options['sort'])
			{
				$order = " ORDER BY hourlogs.$_options[sort] $_options[order] ";
			}
			else
			{
				$order = " ORDER BY `hourlogs`.`id` $_options[order] ";
			}
		}

		$start_limit = $_options['start_limit'];
		$end_limit   = $_options['end_limit'];

		$no_limit = false;
		if($_options['limit'] === false)
		{
			$no_limit = true;
		}


		unset($_options['pagenation']);
		unset($_options['get_count']);
		unset($_options['limit']);
		unset($_options['start_limit']);
		unset($_options['end_limit']);
		unset($_options['get_last']);
		unset($_options['order']);
		unset($_options['sort']);

		foreach ($_options as $key => $value)
		{
			if(is_array($value))
			{
				if(isset($value[0]) && isset($value[1]) && is_string($value[0]) && is_string($value[1]))
				{
					// for similar "search.`field` LIKE '%valud%'"
					$where[] = " hourlogs.$key $value[0] $value[1] ";
				}
			}
			elseif($value === null)
			{
				$where[] = " hourlogs.$key IS NULL ";
			}
			elseif(is_numeric($value))
			{
				$where[] = " hourlogs.$key = $value ";
			}
			elseif(is_string($value))
			{
				$where[] = " hourlogs.$key = '$value' ";
			}
		}

		$where = join($where, " AND ");
		$search = null;
		if($_string != null)
		{
			// $_string = trim($_string);

			// $search = "($search_field LIKE '%$_string%' )";
			// if($where)
			// {
			// 	$search = " AND ". $search;
			// }
		}

		if($where)
		{
			$where = "WHERE $where";
		}
		elseif($search)
		{
			$where = "WHERE";
		}

		if($pagenation && !$get_count)
		{
			$pagenation_query = "SELECT	COUNT(*) AS `count`	FROM `hourlogs` INNER JOIN userteams ON userteams.id = hourlogs.userteam_id	$where $search ";
			$pagenation_query = \lib\db::get($pagenation_query, 'count', true);

			list($limit_start, $limit) = \lib\db::pagnation((int) $pagenation_query, $limit);
			$limit = " LIMIT $limit_start, $limit ";
		}
		else
		{
			// in get count mode the $limit is null
			if($limit)
			{
				$limit = " LIMIT $start_limit, $end_limit ";
			}
		}

		$json = json_encode(func_get_args());
		if($no_limit)
		{
			$limit = null;
		}

		$query = " SELECT $public_fields $where $search $order $limit -- hourlogs::search() 	-- $json";

		if(!$only_one_value)
		{
			$result = \lib\db::get($query, null, false);
			$result = \lib\utility\filter::meta_decode($result);
		}
		else
		{
			$result = \lib\db::get($query, 'searchcount', true);
		}

		return $result;
	}
}
?>