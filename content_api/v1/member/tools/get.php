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

		$shortname = utility::request('shortname');

		if(!$shortname)
		{
			logs::set('api:member:team:shortname:not:set', null, $log_meta);
			debug::error(T_("Id not found"), 'id', 'permission');
			return false;
		}

		$team_detail = \lib\db\teams::access_team($shortname, $this->user_id);

		if(!$team_detail)
		{
			logs::set('api:member:team:id:permission:denide', null, $log_meta);
			debug::error(T_("Can not access to load this team"), 'id', 'permission');
			return false;
		}


		if(isset($team_detail['id']))
		{
			$where            = [];
			$where['team_id'] = $team_detail['id'];
			$where['status']  = 'active';
			$result           = \lib\db\userteams::get($where);

			$temp             = [];
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

		$team = utility::request("team");
		$member  = utility::request("member");

		if(!$team)
		{
			logs::set('api:member:team:notfound', $this->user_id, $log_meta);
			debug::error(T_("Invalid team"), 'team', 'permission');
			return false;
		}

		if(!$member)
		{
			logs::set('api:member:member:notfound', $this->user_id, $log_meta);
			debug::error(T_("Invalid member"), 'member', 'permission');
			return false;
		}

		// $result = \lib\db\members::get_by_brand($team, $member);
		// return $result;
	}

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
				case 'id':
					$result['id'] = \lib\utility\shortURL::encode($value);
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
				case 'allowminus':
				case '24h':
				case 'remote':
					$result[$key] = $value ? true : false;
					break;

				case 'postion':
				case 'displayname':
				case 'fistname':
				case 'lastname':
				case 'status':
				case 'rule':
				case 'telegram_id':
				case 'personnelcode':
					$result[$key] = isset($value) ? (string) $value : null;
					break;

				case 'team_id':
				case 'user_id':
				case 'desc':
				case 'meta':
				case 'createdate':
				case 'date_modified':
				case 'isdefault':
				case 'dateenter':
				case 'dateexit':
				case 'fileid':
				default:
					continue;
					break;
			}
		}
		return $result;
	}
}
?>