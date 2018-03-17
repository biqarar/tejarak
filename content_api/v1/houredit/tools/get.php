<?php
namespace content_api\v1\houredit\tools;


trait get
{
	public $logo_urls = [];

	/**
	 * ready data of houredit to load in api
	 *
	 * @param      <type>  $_data  The data
	 */
	public function ready_houredit($_data, $_options = [])
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
					$result['id'] = \lib\utility\shortURL::encode(intval($value));
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
	public function get_houredit($_options = [])
	{
		\lib\notif::title(T_("Operation Faild"));
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => \lib\utility::request(),
			]
		];

		if(!$this->user_id)
		{
			return false;
		}

		$id = \lib\utility::request("id");
		$id = \lib\utility\shortURL::decode($id);

		if(!$id)
		{
			\lib\db\logs::set('api:houredit:id:not:set', $this->user_id, $log_meta);
			\lib\notif::error(T_("houredit id not set"), 'id', 'arguments');
			return false;
		}

		$result = \lib\db\hourrequests::access_hourrequest_id($id, $this->user_id, ['action' => 'view']);
		if(!$result)
		{
			// \lib\db\logs::set('api:houredit:access:denide', $this->user_id, $log_meta);
			// \lib\notif::error(T_("Can not access to load this houredit details"), 'houredit', 'permission');
			return false;
		}

		\lib\notif::title(T_("Operation complete"));

		$result = $this->ready_houredit($result);

		return $result;
	}

	/**
	 * Gets the houredit list.
	 */
	public function get_houredit_list()
	{
		\lib\notif::title(T_("Operation Faild"));
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => \lib\utility::request(),
			]
		];

		if(!$this->user_id)
		{
			return false;
		}

		$team = \lib\utility::request("team");
		$team = \lib\utility\shortURL::decode($team);

		if(!$team)
		{
			\lib\db\logs::set('api:houredit:team:not:set', $this->user_id, $log_meta);
			\lib\notif::error(T_("houredit team not set"), 'team', 'arguments');
			return false;
		}


		$user = \lib\utility::request("user");
		$user = \lib\utility\shortURL::decode($user);

		if(\lib\utility::request('user') && !$user)
		{
			\lib\db\logs::set('api:houredit:user:invalid', $this->user_id, $log_meta);
			\lib\notif::error(T_("Invalid user id"), 'user', 'arguments');
			return false;
		}

		$check_is_my_team = null;

		if($check_is_my_team = \lib\db\teams::access_team_id($team, $this->user_id, ['action'=> 'view_all_hourrequest']))
		{
			if($user)
			{
				if(!$check_is_my_team = \lib\db\teams::access_team_id($team, $user, ['action'=> 'in_team']))
				{
					\lib\db\logs::set('api:houredit:get:user:is:not:in:team', $this->user_id, $log_meta);
					\lib\notif::error(T_("This user is not in this team"), 'team', 'arguments');
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
			if(!$check_is_my_team = \lib\db\teams::access_team_id($team, $this->user_id, ['action'=> 'in_team']))
			{
				\lib\db\logs::set('api:houredit:get:user:is:not:in:team', $this->user_id, $log_meta);
				\lib\notif::error(T_("No access to load this list"), 'team', 'arguments');
				return false;
			}
			$user = $this->user_id;
		}

		$meta = [];
		$meta['hourrequests.team_id'] = $team;

		if($user)
		{
			$meta['hourrequests.creator'] = $user;
		}

		$meta['hourrequests.status'] = ['<>', "'deleted'"];

		$result = \lib\db\hourrequests::search(null, $meta);

		\lib\notif::title(T_("Operation complete"));
		$temp_result = [];
		foreach ($result as $key => $value)
		{
			if($temp = $this->ready_houredit($value))
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
	public function get_houredit_detail($_options = [])
	{
		\lib\notif::title(T_("Operation Faild"));
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => \lib\utility::request(),
			]
		];

		if(!$this->user_id)
		{
			return false;
		}

		$id = \lib\utility::request("id");
		$id = \lib\utility\shortURL::decode($id);

		if(!$id)
		{
			\lib\db\logs::set('api:houredit:id:not:set', $this->user_id, $log_meta);
			\lib\notif::error(T_("houredit id not set"), 'id', 'arguments');
			return false;
		}

		$result = \lib\db\hourrequests::get(['id' => $id, 'limit' => 1]);

		if(!$result)
		{
			\lib\db\logs::set('api:houredit:access:denide', $this->user_id, $log_meta);
			\lib\notif::error(T_("Can not access to load this houredit details"), 'houredit', 'permission');
			return false;
		}

		\lib\notif::title(T_("Operation complete"));

		$result = $this->ready_houredit($result);

		return $result;
	}

}
?>