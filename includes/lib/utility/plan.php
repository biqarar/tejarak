<?php
namespace lib\utility;
/**
 * Class for plan.
 * check plan feachers
 *
 */
class plan
{


	/**
	 * if user added new team
	 * for 10 days can use from standard plan
	 *
	 * @var        string
	 */
	public static $plan_first = 'standard';
	public static $plan_first_days = 10;

	// all plans feachers
	public static $plans      = [];
	// current team id
	public static $team_id    = 0;
	// current team short name
	public static $shortname  = null;
	// current feacher
	public static $current    = [];
	// list of plans name
	public static $plans_name = [];


	/**
	 * load team data
	 * find the plan of the team
	 * check if user not paid the plan money
	 * return false to disable all feacher
	 * in this time the team simillar the free team plans
	 */
	private static function config_load()
	{
		self::list();
		if(self::$team_id)
		{
			// self::$team_id = \lib\coding::decode(self::$team_id);
			$team_detail   = \lib\db\teams::get_by_id(self::$team_id);
		}
		elseif(self::$shortname)
		{
			$team_detail   = \lib\db\teams::get_by_shortname(self::$shortname);
		}

		if(isset($team_detail['plan']))
		{
			$temp = array_flip(self::$plans_name);
			if(isset($temp[$team_detail['plan']]))
			{
				self::$current = self::$plans[$temp[$team_detail['plan']]];
				return true;
			}
		}
	}


	/**
	 * Gets the details.
	 *
	 * @param      <type>  $_plan_code  The plan code
	 *
	 * @return     <type>  The details.
	 */
	public static function get_detail($_plan_code)
	{
		$list = self::list();

		if(isset($list[$_plan_code]))
		{
			return $list[$_plan_code];
		}
		return null;
	}


	/**
	 * check access this team to this caller or no
	 *
	 * @param      <type>   $_caller  The caller
	 * @param      <type>   $_team    The team
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function access($_caller, $_team = null, $_type = 'id')
	{
		if(!$_team && !self::$team_id && !self::$shortname)
		{
			return false;
		}

		if($_type === 'id')
		{
			if(!$_team)
			{
				$_team = self::$team_id;
			}
			self::$team_id = $_team;
		}

		if($_type === 'shortname')
		{
			if(!$_team)
			{
				$_team = self::$shortname;
			}
			self::$shortname = $_team;
		}

		if(empty(self::$current))
		{
			if(!self::config_load())
			{
				return false;
			}
		}

		if(array_key_exists($_caller,  self::$current['contain']) && self::$current['contain'][$_caller] === true)
		{
			return true;
		}
		return false;
	}


	/**
	 * list of access plans
	 */
	public static function list($_quike = false, $_filip = false)
	{
		$plan             = self::feature_list();

		self::$plans_name = array_combine(array_keys($plan), array_column($plan, 'name'));

		self::$plans      = $plan;

		if($_quike)
		{
			$name = array_column($plan, 'name');
			$plan = array_combine(array_keys($plan), $name);
			if($_filip)
			{
				$plan = array_flip($plan);
			}
			return $plan;
		}

		return $plan;
	}


	/**
	 * get the plan name by get the plan code
	 * alias of teamplans plan name
	 *
	 * @param      <type>  $_plan_code  The plan code
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function plan_name($_plan_code)
	{
		return \lib\db\teamplans::plan_name($_plan_code);
	}


	/**
	 * get the plan code by get the plan name
	 * alias of teamplans plan code
	 *
	 * @param      <type>  $_plan_name  The plan name
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function plan_code($_plan_name)
	{
		return \lib\db\teamplans::plan_code($_plan_name);
	}


	/**
	 * feacher list
	 *
	 * @return     array  ( description_of_the_return_value )
	 */
	public static function feature_list()
	{
		$plan = [];
		/**
		 * plan free
		 */
		$plan[1] =
		[
			'name'       => 'free',
			'detail'     => null,
			'amount'     => 0,
			'prepayment' => false,
			'contain'    =>
			[
				// no thing
			],
		];

		/**
		 * plan pro
		 */
		$plan[2] =
		[
			'name'       => 'pro',
			'detail'     => null,
			'amount'     => 0,
			'prepayment' => false,
			'contain'    =>
			[
				'telegram:enter:msg'              => true,
				'telegram:exit:msg'               => true,
				'telegram:first:of:day:msg'       => true,
				'telegram:first:of:day:date_now'  => true,
				'telegram:first:of:day:msg:group' => true,
				'telegram:end:day:report'         => true,
				'telegram:end:day:report:group'   => true,
				'show:logo'                       => true,
			],
		];

		/**
		 * plan business
		 */
		$plan[3] =
		[
			'name'       => 'business',
			'detail'     => null,
			'amount'     => 0,
			'prepayment' => false,
			'contain'    =>
			[
				'telegram:enter:msg'              => true,
				'telegram:exit:msg'               => true,
				'telegram:first:of:day:msg'       => true,
				'telegram:first:of:day:date_now'  => true,
				'telegram:first:of:day:msg:group' => true,
				'telegram:end:day:report'         => true,
				'telegram:end:day:report:group'   => true,
				'show:logo'                       => true,
			],
		];


		/**
		 * plan simple
		 */
		$plan[4] =
		[
			'name'       => 'simple',
			'detail'     => null,
			'amount'     => 2000,
			'prepayment' => false,
			'contain'    =>
			[
				'telegram:enter:msg'             => true,
				'telegram:exit:msg'              => true,
				'telegram:first:of:day:msg'      => true,
				'telegram:first:of:day:date_now' => true,
				'telegram:end:day:report'        => true,
			],
		];


		/**
		 * plan standard
		 */
		$plan[5] =
		[
			'name'       => 'standard',
			'detail'     => null,
			'amount'     => 10000,
			'prepayment' => false,
			'contain'    =>
			[
				'telegram:enter:msg'              => true,
				'telegram:exit:msg'               => true,
				'telegram:first:of:day:msg'       => true,
				'telegram:first:of:day:date_now'  => true,
				'telegram:first:of:day:msg:group' => true,
				'telegram:end:day:report'         => true,
				'telegram:end:day:report:group'   => true,
				'show:logo'                       => true,
			],
		];

		/**
		 * plan full
		 */
		$plan[6] =
		[
			'name'       => 'full',
			'detail'     => null,
			'amount'     => 499000,
			'prepayment' => true,
			'contain'    =>
			[
				'telegram:enter:msg'              => true,
				'telegram:exit:msg'               => true,
				'telegram:first:of:day:msg'       => true,
				'telegram:first:of:day:date_now'  => true,
				'telegram:first:of:day:msg:group' => true,
				'telegram:end:day:report'         => true,
				'telegram:end:day:report:group'   => true,
				'show:logo'                       => true,
			],
		];

		/**
		 * plan full
		 */
		$plan[7] =
		[
			'name'       => 'full_free',
			'detail'     => null,
			'amount'     => 0,
			'prepayment' => false,
			'contain'    =>
			[
				'telegram:enter:msg'              => true,
				'telegram:exit:msg'               => true,
				'telegram:first:of:day:msg'       => true,
				'telegram:first:of:day:date_now'  => true,
				'telegram:first:of:day:msg:group' => true,
				'telegram:end:day:report'         => true,
				'telegram:end:day:report:group'   => true,
				'show:logo'                       => true,
			],
		];

			/**
		 * plan simple
		 */
		$plan[8] =
		[
			'name'       => 'simple_free',
			'detail'     => null,
			'amount'     => 0,
			'prepayment' => false,
			'contain'    =>
			[
				'telegram:enter:msg'             => true,
				'telegram:exit:msg'              => true,
				'telegram:first:of:day:msg'      => true,
				'telegram:first:of:day:date_now' => true,
				'telegram:end:day:report'        => true,
			],
		];


		/**
		 * plan standard
		 */
		$plan[9] =
		[
			'name'       => 'standard_free',
			'detail'     => null,
			'amount'     => 0,
			'prepayment' => false,
			'contain'    =>
			[
				'telegram:enter:msg'              => true,
				'telegram:exit:msg'               => true,
				'telegram:first:of:day:msg'       => true,
				'telegram:first:of:day:date_now' => true,
				'telegram:first:of:day:msg:group' => true,
				'telegram:end:day:report'         => true,
				'telegram:end:day:report:group'   => true,
				'show:logo'                       => true,
			],
		];

		return $plan;
	}
}
?>