<?php
namespace lib\utility;

class plan
{


	public static $plans      = [];
	public static $team_id    = 0;
	public static $shortname  = null;
	public static $current    = [];
	public static $plans_name = [];

	use plan\config;
	use plan\feature;
	use plan\generate_message;
	use plan\telegram_msg;


	/**
	 * config
	 */
	private static function config_load()
	{
		self::list();
		if(self::$team_id)
		{
			// self::$team_id = \lib\utility\shortURL::decode(self::$team_id);
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
			if(!self::config_load())
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
				// no thing
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
				'telegram:enter:msg',
				'telegram:exit:msg',
				'telegram:first:of:day:msg',
				'telegram:first:of:day:msg:group',
				'telegram:end:day:report',
				'telegram:end:day:report:group',
				'show:logo',
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
				'telegram:enter:msg',
				'telegram:exit:msg',
				'telegram:first:of:day:msg',
				'telegram:first:of:day:msg:group',
				'telegram:end:day:report',
				'telegram:end:day:report:group',
				'show:logo',
			],
		];


		/**
		 * plan simple
		 */
		$plan[4] =
		[
			'name'    => 'simple',
			'detail'  => null,
			'contain' =>
			[
				'telegram:enter:msg',
				'telegram:exit:msg',
				'telegram:first:of:day:msg',
				'telegram:end:day:report',
			],
		];



		/**
		 * plan standard
		 */
		$plan[5] =
		[
			'name'    => 'standard',
			'detail'  => null,
			'contain' =>
			[
				'telegram:enter:msg',
				'telegram:exit:msg',
				'telegram:first:of:day:msg',
				'telegram:first:of:day:msg:group',
				'telegram:end:day:report',
				'telegram:end:day:report:group',
				'show:logo',
			],
		];

		/**
		 * plan full
		 */
		$plan[6] =
		[
			'name'    => 'full',
			'detail'  => null,
			'contain' =>
			[
				'telegram:enter:msg',
				'telegram:exit:msg',
				'telegram:first:of:day:msg',
				'telegram:first:of:day:msg:group',
				'telegram:end:day:report',
				'telegram:end:day:report:group',
				'show:logo',
			],
		];


		self::$plans_name = array_combine(array_keys($plan), array_column($plan, 'name'));
		self::$plans = $plan;
	}
}
?>