<?php
namespace lib\db;
use \lib\db;

class teamplans
{
	/**
	 * the plan change nae whit number of curren permission group
	 *
	 * @var        array
	 */
	public static $PLANS =
	[
		'free'     => 1,
		'pro'      => 2,
		'business' => 3,
	];

	/**
	 * return the plan code
	 *
	 * @param      <type>  $_name  The name
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function plan_code($_name)
	{
		if(isset(self::$PLANS[$_name]))
		{
			return self::$PLANS[$_name];
		}
	}

	/**
	 * get the plan name
	 *
	 * @param      <type>  $_code  The code
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function plan_name($_code)
	{
		$temp = array_flip(self::$PLANS);
		if(isset($temp[$_code]))
		{
			return $temp[$_code];
		}
	}

	/**
	 * add new teamplans
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		return db\config::public_insert('teamplans', ...func_get_args());
	}


	/**
	 * update teamplans record
	 */
	public static function update()
	{
		return db\config::public_update('teamplans', ...func_get_args());
	}

	/**
	 * get current team plan
	 *
	 * @param      <type>   $_team_id  The team identifier
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function current($_team_id)
	{
		if(!$_team_id || !is_numeric($_team_id))
		{
			return false;
		}
		$query = "SELECT * FROM teamplans WHERE teamplans.team_id = $_team_id ORDER BY teamplans.id DESC LIMIT 1";
		$result = \lib\db::get($query, null, true);
		if(isset($result['plan']))
		{
			$result['plan_name'] = self::plan_name($result['plan']);
		}
		return $result;
	}

	/**
	 * set plan of team
	 *
	 * @param      <type>   $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function set($_args)
	{
		$default_args =
		[
			'team_id' => null,
			'plan'    => null,
			'start'   => date("Y-m-d H:i:s"),
			'end'     => null,
			'creator' => null,
			'desc'    => null,
		];

		if(is_array($_args))
		{
			$_args = array_merge($default_args, $_args);
		}

		$log_meta =
		[
			'meta' =>
			[
				'input'   => $_args,
			],
		];

		if(!$_args['team_id'] || !$_args['plan'] || !$_args['creator'] || !$_args['start'])
		{
			return false;
		}

		$_args['plan'] = self::plan_code($_args['plan']);
		if(!$_args['plan'])
		{
			\lib\db\logs::set('plan:cannot:support', $_args['creator'], $log_meta);
			return false;
		}

		$current = self::current($_args['team_id']);
		if(isset($current['id']))
		{
			self::update(['end' => date("Y-m-d H:i:s")], $current['id']);
		}
		$log_meta['meta']['current'] = $current;
		\lib\db\logs::set('plan:changed', $_args['creator'], $log_meta);

		self::insert($_args);
		$update_team =
		[
			'plan'         => self::plan_name($_args['plan']),
			'startplan'    => date("Y-m-d H:i:s"),
			'startplanday' => date("d"),
		];
		\lib\db\teams::update($update_team, $_args['team_id']);
		return true;
	}
}
?>