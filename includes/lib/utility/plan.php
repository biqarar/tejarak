<?php
namespace lib\utility;

class plan
{

	public static $plans      = [];
	public static $team_id    = 0;
	public static $shortname  = null;
	public static $current    = [];
	public static $plans_name = [];

	/**
	 * config
	 */
	private static function config()
	{
		self::list();
		if(self::$team_id)
		{
			self::$team_id = \lib\utility\shortURL::decode(self::$team_id);
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
			if(!self::config())
			{
				return false;
			}
		}

		if(in_array($_caller, self::$current['contain']))
		{
			return true;
		}
		return false;
	}


	/**
	 * list of access plans
	 */
	public static function list()
	{
		$plans = [];
		/**
		 * plan free
		 */
		$plan[1] =
		[
			'name'    => 'free',
			'detail'  => null,
			'contain' =>
			[
				'telegram:report:daily',
				'team:add:10',
			],
		];

		/**
		 * plan pro
		 */
		$plan[2] =
		[
			'name'    => 'pro',
			'detail'  => null,
			'contain' =>
			[
				'telegram:report:daily',
				'telegram:report:exit',
				'team:add:10',
			],
		];

		/**
		 * plan business
		 */
		$plan[3] =
		[
			'name'    => 'business',
			'detail'  => null,
			'contain' =>
			[
				'telegram:report:daily',
				'telegram:report:month',
				'telegram:report:enter',
				'telegram:report:exit',
				'team:add:10',
			],
		];

		self::$plans_name = array_combine(array_keys($plan), array_column($plan, 'name'));
		self::$plans = $plan;
	}
}
?>