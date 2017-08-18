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
	public static $PLANS = [];


	/**
	 * get plan list
	 */
	public static function config()
	{
		if(empty(self::$PLANS))
		{
			self::$PLANS = \lib\utility\plan::list(true, true);
		}
	}


	/**
	 * return the plan code
	 *
	 * @param      <type>  $_name  The name
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function plan_code($_name)
	{
		self::config();

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
		self::config();

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
		$query =
		"
			SELECT
				*
			FROM
				teamplans
			WHERE
				teamplans.team_id = $_team_id AND
				teamplans.status = 'enable'
			ORDER BY
				teamplans.id DESC
			LIMIT 1
		";
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
			'team_id'      => null,
			'plan'         => null,
			'start'        => date("Y-m-d H:i:s"),
			'lastcalcdate' => date("Y-m-d H:i:s"),
			'end'          => null,
			'creator'      => null,
			'desc'         => null,
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

		$team_details = \lib\db\teams::get_by_id($_args['team_id']);

		$log_meta['meta']['team_details'] = $team_details;

		if(isset($team_details['creator']))
		{
			if(intval($team_details['creator']) === intval($_args['creator']))
			{
				// just the creator of team can change
			}
			else
			{
				\lib\db\logs::set('plan:change:not:creator', $_args['creator'], $log_meta);
				\lib\debug::error(T_("Just creator of team can change the plan"));
				return false;
			}
		}
		else
		{
			\lib\db\logs::set('plan:change:team:details:not:found', $_args['creator'], $log_meta);
			return false;
		}

		$_args['status'] = 'enable';

		$_args['plan'] = self::plan_code($_args['plan']);
		if(!$_args['plan'])
		{
			\lib\db\logs::set('plan:cannot:support', $_args['creator'], $log_meta);
			return false;
		}

		$current = self::current($_args['team_id']);

		if(isset($current['plan']) && intval($current['plan']) === intval($_args['plan']))
		{
			\lib\debug::error(T_("This plan is already active for you"));
			return false;
		}

		$update_teamplans        = [];
		$update_teamplans['end'] = date("Y-m-d H:i:s");

		$need_maked_invoice = true;

		if(isset($current['start']) && (time() - strtotime($current['start']) < (60 * 60)))
		{
			$need_maked_invoice = false;
			$update_teamplans['status'] = 'skipped';
		}
		else
		{
			$update_teamplans['status'] = 'disable';
		}

		$prepayment = \lib\utility\plan::get_detail($_args['plan']);

		if(is_array($prepayment) && array_key_exists('prepayment', $prepayment) && $prepayment['prepayment'] === true)
		{
			$prepayment = true;
		}
		else
		{
			$prepayment = false;
		}

		if($need_maked_invoice || $prepayment)
		{
			$maked_invoice = \lib\utility\invoices::team_plan($_args['team_id'], ['current' => $current, 'new' => $_args]);
			// in plan full or other plan
			// if system can not creat invoice
			// we have an error
			// never shoud change team plan
			// for example the full plan need to pay the money before change it!
			if(!$maked_invoice)
			{
				return false;
			}
		}

		if(isset($current['id']))
		{
			self::update($update_teamplans, $current['id']);
		}

		$log_meta['meta']['current'] = $current;

		\lib\db\logs::set('plan:changed', $_args['creator'], $log_meta);
		// insert new teamplans
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