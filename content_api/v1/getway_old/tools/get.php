<?php
namespace content_api\v1\gateway\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait get
{
	/**
	 * Gets the gateway.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The gateway.
	 */
	public function get_list_gateway($_args = [])
	{
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

		if(!utility::request('team'))
		{
			logs::set('api:gateway:team:brand:notfound', null, $log_meta);
			debug::error(T_("team not found"), 'team', 'permission');
			return false;
		}

		$team_id = \lib\db\teams::get_brand(utility::request('team'));

		if(isset($team_id['id']))
		{
			$where               = [];
			$where['team_id'] = $team_id['id'];
			$result               = \lib\db\getwaies::search(null, $where);
			return $result;
		}
	}


	/**
	 * Gets the gateway.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The gateway.
	 */
	public function get_gateway($_args = [])
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
			logs::set('api:gateway:user_id:notfound', null, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		$team = utility::request("team");

		if(!$team)
		{
			logs::set('api:gateway:team:notfound', $this->user_id, $log_meta);
			debug::error(T_("Invalid team"), 'team', 'permission');
			return false;
		}

		$gateway  = utility::request("gateway");
		if(!$gateway)
		{
			logs::set('api:gateway:gateway:notfound', $this->user_id, $log_meta);
			debug::error(T_("Invalid gateway"), 'gateway', 'permission');
			return false;
		}

		$id = utility::request('id');
		if(!$id || !ctype_digit($id))
		{
			logs::set('api:gateway:id:notfound', $this->user_id, $log_meta);
			debug::error(T_("Invalid gateway id"), 'id', 'permission');
			return false;
		}

		$result = \lib\db\getwaies::get(['id' => $id, 'limit' => 1]);

		return $result;
	}




	/**
	 * ready data of member to load in api result
	 *
	 * @param      <type>  $_data     The data
	 * @param      array   $_options  The options
	 *
	 * @return     array   ( description_of_the_return_value )
	 */
	public function ready_gateway($_data, $_options = [])
	{
		$default_options =
		[

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

					$result[$key] = (int) $value;
					// if(isset($_data['code']) && $_data['code'])
					// {
					// 	continue;
					// }
					// else
					// {
					// 	$result['code'] = \lib\utility\shortURL::encode($value);
					// }
					break;

				case 'code':
					if($value)
					{
						$result[$key] = (int) $value;
					}
					else
					{
						if(isset($_data['id']))
						{
							$result[$key] = (int) $_data['id'];
						}
					}

					// if($value)
					// {
					// 	$result['code'] = (int) $value;
					// }
					// else
					// {
					// 	continue;
					// }
					break;

				case 'team_id':
				case 'user_id':
				case 'telegram_id':
					$result[$key] = (int) $value;
					break;

				case 'email':
				case 'displayname':
				case 'status':
				case 'postion':
				case 'desc':
				case 'mobile':
					$result[$key] = (string) $value;
					break;

				case 'date_enter':
				case 'date_exit':
					$result[$key] = strtotime($value);
					break;

				case 'remote':
				case 'is_default':
				case 'full_time':
					if($value)
					{
						$result[$key] = true;
					}
					else
					{
						$result[$key] = false;
					}
					break;

				case 'createdate':
				case 'date_modified':
				case 'meta':
				default:
					continue;
					break;
			}
		}
		return $result;
	}

}
?>