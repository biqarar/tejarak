<?php
namespace content_api\v1\member\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait get
{
	/**
	 * Gets the member.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The member.
	 */
	public function get_list_member($_args = [])
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

		$id = utility::request('id');
		$id = \lib\utility\shortURL::decode($id);

		$shortname =  utility::request('shortname');

		if(!$id && !$shortname)
		{
			logs::set('api:member:team:id:not:set', null, $log_meta);
			debug::error(T_("Id or shortname not set"), 'id', 'arguments');
			return false;
		}
		elseif($id && $shortname)
		{
			logs::set('api:member:team:id:and:shortname:together:set', null, $log_meta);
			debug::error(T_("Can not set id and shortname together"), 'id', 'arguments');
			return false;
		}

		if($id)
		{
			$team_detail = \lib\db\teams::access_team_id($id, $this->user_id);
		}
		elseif($shortname)
		{
			$team_detail = \lib\db\teams::access_team($shortname, $this->user_id);
		}

		if(!$team_detail)
		{
			logs::set('api:member:team:id:permission:denide', null, $log_meta);
			debug::error(T_("Can not access to load this team"), 'id', 'permission');
			return false;
		}

		$get_hours = utility::request('hours');
		$get_hours = $get_hours ? true : false;

		if(isset($team_detail['id']))
		{
			$where              = [];
			$where['team_id']   = $team_detail['id'];
			$where['get_hours'] = $get_hours;
			$where['status']    = ['IN', "('active', 'deactive')"];
			$result             = \lib\db\userteams::get_list($where);
			$temp               = [];
			if(is_array($result))
			{
				foreach ($result as $key => $value)
				{
					$temp[] = $this->ready_member($value);
				}
			}
			return $temp;
		}
	}


	/**
	 * Gets the member.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The member.
	 */
	public function get_member($_args = [])
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
			logs::set('api:member:user_id:notfound', null, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		$MEMBER_REQUEST = utility::request();

		$team = utility::request('team');

		if(!$team)
		{
			logs::set('api:member:team:not:set', $this->user_id, $log_meta);
			debug::error(T_("Team not set"), 'team', 'arguments');
			return false;
		}


		$id = utility::request('id');
		$id = utility\shortURL::decode($id);
		if(!$id)
		{
			logs::set('api:member:id:not:set', $this->user_id, $log_meta);
			debug::error(T_("Id not set"), 'id', 'arguments');
			return false;
		}

		utility::set_request_array(['id' => $team]);

		$team_detail = $this->get_team();

		if(!debug::$status || !isset($team_detail['id']))
		{
			return false;
		}

		$team_id = utility\shortURL::decode($team_detail['id']);

		utility::set_request_array($MEMBER_REQUEST);

		$check_user_in_team = \lib\db\userteams::get_list(['user_id' => $id, 'team_id' => $team_id, 'limit' => 1]);
		// var_dump($check_user_in_team);exit();
		if(!$check_user_in_team)
		{
			logs::set('api:member:user:not:in:team', $this->user_id, $log_meta);
			debug::error(T_("This user is not in this team"), 'id', 'arguments');
			return false;
		}

		$result = $this->ready_member($check_user_in_team);

		return $result;
	}


	/**
	 * { function_description }
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function userteam_get_details()
	{
		$userteam_id  = utility::request("id");

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
			logs::set('api:member:user_id:not:set:userteam_get_details', null, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		if(!$userteam_id)
		{
			logs::set('api:userteam_id:team:not:set', $this->user_id, $log_meta);
			debug::error(T_("Invalid team id"), 'team', 'permission');
			return false;
		}

		$load_detail  = \lib\db\userteams::get_by_id($userteam_id, $this->user_id);

		return $load_detail;
	}


	/**
	 * ready data of member to load in api result
	 *
	 * @param      <type>  $_data     The data
	 * @param      array   $_options  The options
	 *
	 * @return     array   ( description_of_the_return_value )
	 */
	public function ready_member($_data, $_options = [])
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
				case 'user_id':
					$result['user_id'] = \lib\utility\shortURL::encode($value);
					break;

				case 'fileurl':
					if($value)
					{
						$result['file'] = $this->host('file'). '/'. $value;
					}
					else
					{
						$result['file'] = null;
					}
					break;

				case 'allowplus':
					$result['allow_plus'] = $value ? true : false;
					break;
				case 'allowminus':
					$result['allow_minus'] = $value ? true : false;
					break;
				case '24h':
					$result['24h'] = $value ? true : false;
					break;
				case 'remote':
					$result['remote_user'] = $value ? true : false;
					break;

				case 'plus':
					$result[$key] = isset($value) ? (int) $value : null;
					break;
				case 'postion':
				case 'displayname':
				case 'firstname':
				case 'lastname':
				case 'status':
				case 'rule':
				case 'telegram_id':
				case 'mobile':
				case 'last_time':
					$result[$key] = isset($value) ? (string) $value : null;
					break;
				case 'personnelcode':
					$result['personnel_code'] = isset($value) ? (string) $value : null;
					break;
				case 'id':
				case 'team_id':
				case 'desc':
				case 'meta':
				case 'createdate':
				case 'fileid':
				case 'date_modified':
				case 'isdefault':
				case 'dateenter':
				case 'dateexit':
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