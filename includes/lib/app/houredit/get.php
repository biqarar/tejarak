<?php
namespace lib\app\houredit;


trait get
{
	public static $logo_urls = [];

	/**
	 * ready data of houredit to load in api
	 *
	 * @param      <type>  $_data  The data
	 */
	public static function ready_houredit($_data, $_options = [])
	{
		$default_options =
		[
			'check_is_my_houredit' => true,
		];

		if(!is_array($_options))
		{
			$_options = [];
		}

		$_options = array_merge($default_options, $_options);

		$result = [];
		foreach ($_data as $key => $value)
		{
			switch ($key)
			{
				case 'id':
				// case 'hour_id':
					$result['id'] = \dash\coding::encode(intval($value));
					break;

				case 'shamsi_date':
					$result['shamsi_date'] = $value;
					break;

				default:
					if(isset($value))
					{
						$result[$key] = $value;
					}
					else
					{
						$result[$key] = null;
					}
					break;
			}

		}
		return $result;
	}


	/**
	 * Gets the houredit.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The houredit.
	 */
	public static function get_houredit($_options = [])
	{
		// \dash\notif::title(T_("Operation Faild"));
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => \dash\app::request(),
			]
		];

		if(!\dash\user::id())
		{
			return false;
		}

		$id = \dash\app::request("id");
		$id = \dash\coding::decode($id);

		if(!$id)
		{
			\dash\db\logs::set('api:houredit:id:not:set', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("houredit id not set"), 'id', 'arguments');
			return false;
		}

		$result = \lib\db\hourrequests::access_hourrequest_id($id, \dash\user::id(), ['action' => 'view']);
		if(!$result)
		{
			// \dash\db\logs::set('api:houredit:access:denide', \dash\user::id(), $log_meta);
			// \dash\notif::error(T_("Can not access to load this houredit details"), 'houredit', 'permission');
			return false;
		}

		// \dash\notif::title(T_("Operation complete"));

		$result = self::ready_houredit($result);

		return $result;
	}

	/**
	 * Gets the houredit list.
	 */
	public static function get_houredit_list()
	{
		// \dash\notif::title(T_("Operation Faild"));
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => \dash\app::request(),
			]
		];

		if(!\dash\user::id())
		{
			return false;
		}

		$team = \dash\app::request("team");
		$team = \dash\coding::decode($team);

		if(!$team)
		{
			\dash\db\logs::set('api:houredit:team:not:set', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("houredit team not set"), 'team', 'arguments');
			return false;
		}


		$user = \dash\app::request("user");
		$user = \dash\coding::decode($user);

		if(\dash\app::request('user') && !$user)
		{
			\dash\db\logs::set('api:houredit:user:invalid', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Invalid user id"), 'user', 'arguments');
			return false;
		}

		$check_is_my_team = null;

		if($check_is_my_team = \lib\db\teams::access_team_id($team, \dash\user::id(), ['action'=> 'view_all_hourrequest']))
		{
			if($user)
			{
				if(!$check_is_my_team = \lib\db\teams::access_team_id($team, $user, ['action'=> 'in_team']))
				{
					\dash\db\logs::set('api:houredit:get:user:is:not:in:team', \dash\user::id(), $log_meta);
					\dash\notif::error(T_("This user is not in this team"), 'team', 'arguments');
					return false;
				}
			}
			else
			{
				$user = null;
			}
		}
		else
		{
			if(!$check_is_my_team = \lib\db\teams::access_team_id($team, \dash\user::id(), ['action'=> 'in_team']))
			{
				\dash\db\logs::set('api:houredit:get:user:is:not:in:team', \dash\user::id(), $log_meta);
				\dash\notif::error(T_("No access to load this list"), 'team', 'arguments');
				return false;
			}
			$user = \dash\user::id();
		}

		$meta = [];
		$meta['hourrequests.team_id'] = $team;

		if($user)
		{
			$meta['hourrequests.creator'] = $user;
		}

		$meta['hourrequests.status'] = ['<>', "'deleted'"];

		$result = \lib\db\hourrequests::search(null, $meta);

		// \dash\notif::title(T_("Operation complete"));
		$temp_result = [];
		foreach ($result as $key => $value)
		{
			if($temp = self::ready_houredit($value))
			{
				$temp_result[] = $temp;
			}
		}

		return $temp_result;
	}

	/**
	 * Gets the houredit.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The houredit.
	 */
	public static function get_houredit_detail($_options = [])
	{
		// \dash\notif::title(T_("Operation Faild"));
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => \dash\app::request(),
			]
		];

		if(!\dash\user::id())
		{
			return false;
		}

		$id = \dash\app::request("id");
		$id = \dash\coding::decode($id);

		if(!$id)
		{
			\dash\db\logs::set('api:houredit:id:not:set', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("houredit id not set"), 'id', 'arguments');
			return false;
		}

		$result = \lib\db\hourrequests::get(['id' => $id, 'limit' => 1]);

		if(!$result)
		{
			\dash\db\logs::set('api:houredit:access:denide', \dash\user::id(), $log_meta);
			\dash\notif::error(T_("Can not access to load this houredit details"), 'houredit', 'permission');
			return false;
		}

		// \dash\notif::title(T_("Operation complete"));

		$result = self::ready_houredit($result);

		return $result;
	}

}
?>