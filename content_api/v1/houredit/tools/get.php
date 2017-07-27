<?php
namespace content_api\v1\houredit\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

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
		debug::title(T_("Operation Faild"));
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => utility::request(),
			]
		];

		if(!$this->user_id)
		{
			return false;
		}

		$id = utility::request("id");
		$id = \lib\utility\shortURL::decode($id);

		if(!$id)
		{
			logs::set('api:houredit:id:not:set', $this->user_id, $log_meta);
			debug::error(T_("houredit id not set"), 'id', 'arguments');
			return false;
		}

		$result = \lib\db\hourrequests::access_hourrequest_id($id, $this->user_id, ['action' => 'view']);
		if(!$result)
		{
			// logs::set('api:houredit:access:denide', $this->user_id, $log_meta);
			// debug::error(T_("Can not access to load this houredit details"), 'houredit', 'permission');
			return false;
		}

		debug::title(T_("Operation complete"));

		$result = $this->ready_houredit($result);

		return $result;
	}

	/**
	 * Gets the houredit list.
	 */
	public function get_houredit_list()
	{
		debug::title(T_("Operation Faild"));
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => utility::request(),
			]
		];

		if(!$this->user_id)
		{
			return false;
		}

		$team = utility::request("team");
		$team = \lib\utility\shortURL::decode($team);

		if(!$team)
		{
			logs::set('api:houredit:team:not:set', $this->user_id, $log_meta);
			debug::error(T_("houredit team not set"), 'team', 'arguments');
			return false;
		}


		$user = utility::request("user");
		$user = \lib\utility\shortURL::decode($user);

		if(!$user)
		{
			logs::set('api:houredit:user:not:set', $this->user_id, $log_meta);
			debug::error(T_("houredit user not set"), 'user', 'arguments');
			return false;
		}

		$meta = [];
		$meta['team_id'] = $team;
		$meta['creator'] = $user;
		$meta['status'] = ['<>', "'deleted'"];
		$result = \lib\db\hourrequests::search(null, $meta);

		debug::title(T_("Operation complete"));
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
		debug::title(T_("Operation Faild"));
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => utility::request(),
			]
		];

		if(!$this->user_id)
		{
			return false;
		}

		$id = utility::request("id");
		$id = \lib\utility\shortURL::decode($id);

		if(!$id)
		{
			logs::set('api:houredit:id:not:set', $this->user_id, $log_meta);
			debug::error(T_("houredit id not set"), 'id', 'arguments');
			return false;
		}

		$result = \lib\db\hourrequests::get(['id' => $id, 'limit' => 1]);

		if(!$result)
		{
			logs::set('api:houredit:access:denide', $this->user_id, $log_meta);
			debug::error(T_("Can not access to load this houredit details"), 'houredit', 'permission');
			return false;
		}

		debug::title(T_("Operation complete"));

		$result = $this->ready_houredit($result);

		return $result;
	}

}
?>