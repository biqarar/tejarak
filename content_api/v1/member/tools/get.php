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

		if(!utility::request('team'))
		{
			logs::set('api:member:team:brand:notfound', null, $log_meta);
			debug::error(T_("team not found"), 'team', 'permission');
			return false;
		}

		$team_id = \lib\db\teams::get_brand(utility::request('team'));

		if(utility::request('branch'))
		{
			$branch_id = \lib\db\branchs::get_by_brand(utility::request('team'), utility::request('branch'));
		}

		if(isset($team_id['id']))
		{
			$where            = [];
			$where['team_id'] = $team_id['id'];

			if(isset($branch_id['id']))
			{
				$where['branch_id'] = $branch_id['id'];
				$result           = \lib\db\userbranchs::get($where);
			}
			else
			{
				$result           = \lib\db\userteams::get($where);
			}

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
				case 'name':
				case 'family':
					$result[$key] = (string) $value;
					break;

				case 'user_name':
				case 'user_family':
				case 'user_displayname':
				case 'user_status':
					$result[substr($key, 5)] = (string) $value;
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

				case 'file_detail':
					if(is_string($value) && substr($value, 0, 1) === '{')
					{
						$value = json_decode($value, true);
					}

					if(isset($value['url']))
					{
						$result['file'] = Protocol."://" . \lib\router::get_root_domain(). '/'. $value['url'];
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