<?php
namespace content_api\v1\gateway\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait get
{
	public $remote_user         = false;
	public $rule                = null;
	public $show_another_status = false;
	public $team_privacy        = 'private';

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
			// return false;
		}

		$id = utility::request('id');
		$id = \lib\utility\shortURL::decode($id);

		$shortname =  utility::request('shortname');

		if(!$id && !$shortname)
		{
			logs::set('api:gateway:team:id:not:set', null, $log_meta);
			debug::error(T_("Id or shortname not set"), 'id', 'arguments');
			return false;
		}
		elseif($id && $shortname)
		{
			logs::set('api:gateway:team:id:and:shortname:together:set', null, $log_meta);
			debug::error(T_("Can not set id and shortname together"), 'id', 'arguments');
			return false;
		}

		if($id)
		{
			$team_detail = \lib\db\teams::access_team_id($id, $this->user_id, ['action' => 'get_gateway']);
		}
		elseif($shortname)
		{
			$team_detail = \lib\db\teams::access_team($shortname, $this->user_id, ['action' => 'get_gateway']);
		}

		if(!$team_detail)
		{
			logs::set('api:gateway:team:id:permission:denide', null, $log_meta);
			debug::error(T_("Can not access to load this team"), 'id', 'permission');
			return false;
		}

		if(isset($team_detail['id']))
		{
			$where            = [];
			$where['team_id'] = $team_detail['id'];
			$where['rule']    = 'gateway';
			$where['status']  = ['IN', "('active', 'deactive')"];
			$result           = \lib\db\userteams::get_list($where);

			$temp             = [];
			if(is_array($result))
			{
				foreach ($result as $key => $value)
				{
					$a = $this->ready_gateway($value, ['condition_checked' => true]);
					if($a)
					{
						$temp[] = $a;
					}
				}
			}
			return $temp;
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

		$team = utility::request('team');
		if(!$team)
		{
			logs::set('api:gateway:team:not:set', $this->user_id, $log_meta);
			debug::error(T_("Team not set"), 'team', 'arguments');
			return false;
		}

		$id = utility::request('id');
		$id = utility\shortURL::decode($id);
		if(!$id)
		{
			logs::set('api:gateway:id:not:set', $this->user_id, $log_meta);
			debug::error(T_("Id not set"), 'id', 'arguments');
			return false;
		}

		$team_detail = \lib\db\teams::access_team_code($team, $this->user_id, ['action' => 'edit_gateway']);

		if(!isset($team_detail['id']))
		{
			return false;
		}

		$team_id = $team_detail['id'];

		$check_user_in_team = \lib\db\userteams::get_list(['user_id' => $id, 'team_id' => $team_id, 'rule' => 'gateway', 'limit' => 1]);

		if(!$check_user_in_team)
		{
			logs::set('api:gateway:user:not:in:team', $this->user_id, $log_meta);
			debug::error(T_("This user is not in this team"), 'id', 'arguments');
			return false;
		}

		$result = $this->ready_gateway($check_user_in_team, ['condition_checked' => true]);

		return $result;
	}


	/**
	 * ready data of gateway to load in api result
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
			'condition_checked' => false,
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
				case 'user_id':
					$result['user_id'] = \lib\utility\shortURL::encode($value);
					break;

				case 'displayname':
					$result['name'] = $value;
					break;
				case 'firstname':
					$result['ip'] = $value;
					break;
				case 'lastname':
					$result['agent'] = $value;
					break;
				case 'username':
					$result['username'] = $value;
					break;
				case 'rule':
				case 'telegram_id':
				case 'status':
				case 'last_time':
					$result[$key] = isset($value) ? (string) $value : null;
					break;
				case 'personnelcode':
					$result['personnel_code'] = isset($value) ? (string) $value : null;
					break;

				default:
					continue;
					break;
			}
		}
		krsort($result);
		return $result;
	}
}
?>