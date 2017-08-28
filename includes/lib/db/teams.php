<?php
namespace lib\db;
use \lib\db;

class teams
{
	use teams\report;
	use teams\active_deactive_member;

	// default setttings
	// save in temas.meta
	public static $default_settings =
	[
		'telegram_group'    => false,
		'first_member_name' => false,
		'report_daily'      => false,
		'report_daily_time' => false,
		'report_daily_gold' => false,
		'report_count'      => 0,
	];

	public static $default_settings_true =
	[
		'telegram_group'    => true,
		'first_member_name' => true,
		'report_daily'      => true,
		'report_daily_time' => true,
		'report_daily_gold' => true,
		'report_count'      => -1,
	];

	/**
	 * SAVE OFFLINE RESULT
	 *
	 * @var        array
	 */
	public static $TEAMS_SHORT_NAME = [];
	public static $TEAMS_ID         = [];

	public static $public_fields =
	"
		teams.*,
		userteams.*,
		userteams.id             	AS `userteam_id`,
		teams.id                 	AS `id`,
		teams.status             	AS `status`,
		teams.name               	AS `name`,
		teams.website            	AS `website`,
		teams.desc               	AS `desc`,
		teams.alias              	AS `alias`,
		teams.privacy            	AS `privacy`,
		teams.shortname          	AS `shortname`,
		teams.showavatar         	AS `showavatar`,
		teams.allowplus          	AS `allowplus`,
		teams.allowminus         	AS `allowminus`,
		teams.remote             	AS `remote`,
		teams.24h                	AS `24h`,
		teams.logourl            	AS `logourl`,
		teams.logo               	AS `logo`,
		teams.manualtimeenter     	AS `manualtimeenter`,
		teams.manualtimeexit      	AS `manualtimeexit`,
		userteams.manualtimeenter 	AS `userteam_manualtimeenter`,
		userteams.manualtimeexit  	AS `userteam_manualtimeexit`,
		userteams.telegram_id     	AS `userteam_telegram_id`,
		userteams.24h             	AS `userteam_24h`,
		userteams.remote          	AS `userteam_remote`,
		userteams.allowminus      	AS `userteam_allowminus`,
		userteams.allowplus       	AS `userteam_allowplus`,
		userteams.status          	AS `userteam_status`,
		userteams.fileid          	AS `userteam_fileid`,
		userteams.fileurl         	AS `userteam_fileurl`,
		userteams.isdefault       	AS `userteam_isdefault`,
		userteams.createdate     	AS `userteam_createdate`,
		userteams.date_modified  	AS `userteam_date_modified`
	";


	/**
	 * add new team
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
			\lib\db::query("INSERT INTO teams SET $set");
			return \lib\db::insert_id();
		}
	}



	/**
	 * Gets all admins.
	 *
	 * @param      <type>  $_team_id  The team identifier
	 *
	 * @return     <type>  All admins.
	 */
	public static function get_all_admins($_team_id)
	{
		if(!$_team_id || !is_numeric($_team_id))
		{
			return false;
		}

		$field = self::$public_fields;
		$query =
		"
			SELECT
				$field
			FROM
				teams
			LEFT JOIN userteams ON userteams.team_id = teams.id
			WHERE
				userteams.team_id = $_team_id AND
				userteams.rule   = 'admin' AND
				userteams.status = 'active'
		";
		return \lib\db::get($query);
	}


	/**
	 * Gets the shortname.
	 * get team by shortname
	 * @param      <type>  $_shortname  The shortname
	 *
	 * @return     <type>  The shortname.
	 */
	public static function get_by_id($_id)
	{
		if(!isset(self::$TEAMS_ID[$_id]))
		{
			if($_id)
			{
				$query = "SELECT * FROM teams WHERE teams.id = '$_id' LIMIT 1";
				self::$TEAMS_ID[$_id] = \lib\db::get($query, null, true);
			}
		}

		if(isset(self::$TEAMS_ID[$_id]))
		{
			return self::$TEAMS_ID[$_id];
		}
		return null;
	}

	/**
	 * Gets the shortname.
	 * get team by shortname
	 * @param      <type>  $_shortname  The shortname
	 *
	 * @return     <type>  The shortname.
	 */
	public static function get_by_shortname($_shortname)
	{
		if(!isset(self::$TEAMS_SHORT_NAME[$_shortname]))
		{
			if($_shortname)
			{
				$query = "SELECT * FROM teams WHERE teams.shortname = '$_shortname' LIMIT 1";
				self::$TEAMS_SHORT_NAME[$_shortname] = \lib\db::get($query, null, true);
			}
		}

		if(isset(self::$TEAMS_SHORT_NAME[$_shortname]))
		{
			return self::$TEAMS_SHORT_NAME[$_shortname];
		}
		return null;
	}


	/**
	 * get team record
	 *
	 * @param      <type>  $_id    The identifier
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		return \lib\db\config::public_get('teams', ...func_get_args());
	}


	/**
	 * update team
	 *
	 * @param      <type>  $_args  The arguments
	 * @param      <type>  $_id    The identifier
	 */
	public static function update()
	{
		// clear cash
		self::$TEAMS_SHORT_NAME = [];

		return \lib\db\config::public_update('teams', ...func_get_args());
	}


	/**
	 * Determines if my team.
	 * check if this team is my tam
	 * @param      <type>  $_team  The team
	 * @param      <type>  $_boss  The boss
	 */
	public static function access_team($_team, $_user_id, $_options = [])
	{

		if(!$_team)
		{
			return false;
		}

		$default_options =
		[
			'action'           => null,
			'type'             => 'shortname',
			'change_hour_user' => null,
		];

		if(is_array($_options))
		{
			$_options = array_merge($default_options, $_options);
		}

		$query = null;

		$field = self::$public_fields;

		switch ($_options['action'])
		{
			/**
			 * if the team is public no problem to load data of team
			 * if is private cannot access to load
			 */
			case 'view':
			case 'get_member':
				if(!$_user_id || !is_numeric($_user_id))
				{
					$_user_id = 0;
				}

				$query =
				"
					SELECT
						$field
					FROM
						teams
					LEFT JOIN userteams ON userteams.team_id = teams.id AND userteams.user_id = $_user_id
					WHERE
						teams.$_options[type]   = '$_team' AND
						(
							(
								userteams.user_id = $_user_id AND
								userteams.rule    = 'admin'
							)
							OR
							(
								teams.privacy     = 'team' AND
								userteams.user_id = $_user_id AND
								userteams.rule    = 'user'
							)
							OR
							(
								userteams.user_id = $_user_id AND
								userteams.rule    = 'gateway'
							)
							OR
							(
								userteams.user_id = $_user_id AND
								userteams.remote  = 1
							)
							OR
							(
								teams.privacy = 'public'
							)
						)
					LIMIT 1
				";
				break;

			/**
			 * the use must be in team
			 * user or admin or eny thing
			 */
			case 'report_u':
			case 'in_team':
			case 'my_team':
				if(!$_user_id || !is_numeric($_user_id))
				{
					return false;
				}
				$query =
				"
					SELECT
						$field
					FROM
						teams
					INNER JOIN userteams ON userteams.team_id = teams.id
						WHERE
						teams.$_options[type] = '$_team' AND
						userteams.user_id = $_user_id
					LIMIT 1
				";
				break;

			/**
			 * the user must be admin of team to load this data
			 */
			case 'report_last':
			case 'view_all_hourrequest':
			case 'report_last_all':
			case 'report_month_all':
			case 'report_period_all':
			case 'report_sum':
			case 'report_last':
			case 'close':
			case 'delete':
			case 'add_member':
			case 'edit_member':
			case 'add_gateway':
			case 'edit_gateway':
			case 'get_gateway':
			case 'edit':
			case 'admin':
				if(!$_user_id || !is_numeric($_user_id))
				{
					return false;
				}

				$query =
				"
					SELECT
						$field
					FROM
						teams
					INNER JOIN userteams ON userteams.team_id = teams.id
						WHERE
						teams.$_options[type] = '$_team' AND
						userteams.user_id = $_user_id AND
						userteams.rule    = 'admin'
					LIMIT 1
				";
				break;

			case 'save_hours':
				if(!$_user_id || !is_numeric($_user_id) || !$_options['change_hour_user'] || !is_numeric($_options['change_hour_user']))
				{
					return false;
				}

				$query =
				"
					SELECT
						$field
					FROM
						teams
					INNER JOIN userteams ON userteams.team_id = teams.id
						WHERE
						teams.$_options[type] = '$_team' AND
						(
							(
								userteams.user_id = $_user_id AND
								userteams.rule    = 'admin'
							)
							OR
							(
								userteams.user_id = $_user_id AND
								userteams.rule    = 'gateway' AND
								$_user_id != $_options[change_hour_user]
							)
							OR
							(
								userteams.user_id = $_options[change_hour_user] AND
								userteams.remote = 1 AND
								$_user_id = $_options[change_hour_user]
							)
						)
					LIMIT 1
				";
				break;

				default:
					return false;
					break;
		}

		if(!$query)
		{
			return false;
		}

		$result =  \lib\db::get($query, null, true);

		return $result;
	}


	/**
	 * Determines if my team.
	 * check if this team is my tam
	 * @param      <type>  $_team  The team
	 * @param      <type>  $_boss  The boss
	 */
	public static function access_team_id($_team_id, $_user_id, $_options = [])
	{
		if(!is_array($_options))
		{
			$_options = [];
		}

		$_options = array_merge($_options, ['type' => 'id']);

		return self::access_team($_team_id, $_user_id, $_options);
	}


	/**
	 * Determines if my team.
	 * check if this team is my tam
	 * @param      <type>  $_team  The team
	 * @param      <type>  $_boss  The boss
	 */
	public static function access_team_code($_code, $_user_id, $_options = [])
	{
		if(!is_array($_options))
		{
			$_options = [];
		}

		$_options = array_merge($_options, ['type' => 'id']);
		$id = \lib\utility\shortURL::decode($_code);
		if(!$id)
		{
			return false;
		}
		return self::access_team($id, $_user_id, $_options);
	}


	/**
	 * team list
	 *
	 * @param      <type>   $_team     The team
	 * @param      <type>   $_user_id  The user identifier
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function team_list($_user_id)
	{
		if(!$_user_id || !is_numeric($_user_id))
		{
			return false;
		}

		$query =
		"
			SELECT
				teams.*,
				userteams.rule
			FROM
				teams
			INNER JOIN userteams ON userteams.team_id = teams.id
			WHERE
				userteams.user_id = $_user_id
		";

		$result =  \lib\db::get($query);
		return $result;
	}

	/**
	 * Gets the similar shortname.
	 * GET list of shortname like this
	 * for change when duplicate
	 * @param      <type>  $_like  The like
	 *
	 * @return     <type>  The similar shortname.
	 */
	public static function get_similar_shortname($_like)
	{
		$query = "SELECT teams.shortname AS `shortname` FROM teams WHERE teams.shortname LIKE '$_like%' ";
		return \lib\db::get($query, 'shortname');
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
			// default return of this function 10 last record of team
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
			$public_fields  = " COUNT(teams.id) AS 'teamscount' FROM	teams";
			$limit          = null;
			$only_one_value = true;
		}
		else
		{
			$limit         = null;
			$public_fields = " * FROM teams";

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
				$order = " ORDER BY $_options[sort] $_options[order] ";
			}
			else
			{
				$order = " ORDER BY teams.id DESC ";
			}
		}
		else
		{
			if($_options['sort'])
			{
				$order = " ORDER BY $_options[sort] $_options[order] ";
			}
			else
			{
				$order = " ORDER BY teams.id $_options[order] ";
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
					// for similar "teams.`field` LIKE '%valud%'"
					$where[] = " teams.`$key` $value[0] $value[1] ";
				}
			}
			elseif($value === null)
			{
				$where[] = " teams.`$key` IS NULL ";
			}
			elseif(is_numeric($value))
			{
				$where[] = " teams.`$key` = $value ";
			}
			elseif(is_string($value))
			{
				$where[] = " teams.`$key` = '$value' ";
			}
		}

		$where = join($where, " AND ");
		$search = null;
		if($_string != null)
		{
			$_string = trim($_string);

			$search = "(teams.name  LIKE '%$_string%' )";
			if($where)
			{
				$search = " AND ". $search;
			}
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
			$pagenation_query = "SELECT	COUNT(teams.id) AS `count`	FROM teams	$where $search ";
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
		$query = " SELECT $public_fields $where $search $order $limit -- teams::search() 	-- $json";

		if(!$only_one_value)
		{
			$result = \lib\db::get($query, null, false);
			$result = \lib\utility\filter::meta_decode($result);
		}
		else
		{
			$result = \lib\db::get($query, 'teamscount', true);
		}

		return $result;
	}

}
?>