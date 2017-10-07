<?php
namespace content_api\v1\member\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait get
{
	use get_barcodes;

	public $remote_user         = false;
	public $rule                = null;
	public $show_another_status = false;
	public $team_privacy        = 'private';

	/**
	 * Gets the member.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The member.
	 */
	public function get_list_member($_args = [])
	{
		$default_args =
		[
			'pagenation' => true,
			'admin'  	 => false,
		];

		if(!is_array($_args))
		{
			$_args = [];
		}

		$_args = array_merge($default_args, $_args);

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
		// in this api must be get the team
		// but i get the id
		// this is incurrect
		$team = utility::request('team');
		$team = \lib\utility\shortURL::decode($team);
		if($team && !$id)
		{
			$id = $team;
		}

		$shortname =  utility::request('shortname');

		if(!$id && !$shortname)
		{
			logs::set('api:member:team:id:not:set', $this->user_id, $log_meta);
			debug::error(T_("Id or shortname not set"), 'id', 'arguments');
			return false;
		}
		elseif($id && $shortname)
		{
			logs::set('api:member:team:id:and:shortname:together:set', $this->user_id, $log_meta);
			debug::error(T_("Can not set id and shortname together"), 'id', 'arguments');
			return false;
		}

		if($id)
		{
			$inside_method = 'get_member';
			$team_detail = \lib\db\teams::access_team_id($id, $this->user_id, ['action' => 'get_member']);
		}
		elseif($shortname)
		{
			$inside_method = 'view';
			$team_detail = \lib\db\teams::access_team($shortname, $this->user_id, ['action' => 'view']);
		}

		if(!$team_detail)
		{
			if($id)
			{
				$team_detail = \lib\db\teams::access_team_id($id, $this->user_id, ['action' => 'supervisor:get_member']);
			}
			elseif($shortname)
			{
				$team_detail = \lib\db\teams::access_team($shortname, $this->user_id, ['action' => 'supervisor:view']);
			}

			if($team_detail)
			{
				if(\lib\permission::access('load:all:team', null, $this->user_id) || $_args['admin'])
				{
					$team_detail = $team_detail;
				}
				else
				{
					\lib\temp::set('team_access_denied', true);
					\lib\temp::set('team_exist', true);
					$team_detail = false;
				}
			}
		}

		if(!$team_detail)
		{
			logs::set('api:member:team:id:permission:denide', $this->user_id, $log_meta);
			debug::error(T_("Can not access to load this team"), 'id', 'permission');
			return false;
		}

		$get_hours = utility::request('hours');
		$get_hours = $get_hours ? true : false;

		if(isset($team_detail['userteam_remote']) && $team_detail['userteam_remote'])
		{
			$this->remote_user = true;
		}

		if(isset($team_detail['privacy']))
		{
			$this->team_privacy = $team_detail['privacy'];
		}

		if(isset($team_detail['rule']))
		{
			$this->rule = $team_detail['rule'];
		}

		$this->show_another_status = true;

		$type = utility::request('type');
		if($type && !is_string($type))
		{
			logs::set('api:member:team:type:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid type of user"), 'type', 'arguments');
			return false;
		}

		$search = utility::request('search');
		if($search && !is_string($search))
		{
			logs::set('api:member:team:search:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid search of user"), 'search', 'arguments');
			return false;
		}

		if(isset($team_detail['id']))
		{
			$where               = [];
			$where['team_id']    = $team_detail['id'];
			$where['get_hours']  = $get_hours;
			$where['status']     = ['IN', "('active', 'deactive')"];
			$where['rule']       = ['IN', "('user', 'admin')"];
			$where['pagenation'] = $_args['pagenation'];
			if($type)
			{
				$where['type']       = $type ? $type : null;
			}
			$where['search']	 = $search ? $search : null;
			$result              = \lib\db\userteams::get_list($where);
			$temp                = [];

			if(is_array($result))
			{
				foreach ($result as $key => $value)
				{
					$a = $this->ready_member($value, ['inside_method' => $inside_method]);
					if($a)
					{
						$temp[] = $a;
					}
				}
			}
			$this->get_barcodes($temp);
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
			logs::set('api:member:user_id:notfound', $this->user_id, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}
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

		$team_detail = \lib\db\teams::access_team_code($team, $this->user_id, ['action' => 'edit_member']);

		if(!isset($team_detail['id']))
		{
			return false;
		}

		$team_id = $team_detail['id'];

		$check_user_in_team = \lib\db\userteams::get_list(['id' => $id, 'team_id' => $team_id,'rule' => ['IN', "('user', 'admin')"], 'limit' => 1]);

		if(!$check_user_in_team)
		{
			logs::set('api:member:user:not:in:team', $this->user_id, $log_meta);
			debug::error(T_("This user is not in this team"), 'id', 'arguments');
			return false;
		}

		$result = $this->ready_member($check_user_in_team, ['condition_checked' => true]);

		$this->get_barcodes($result);

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
			logs::set('api:member:user_id:not:set:userteam_get_details', $this->user_id, $log_meta);
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
			'condition_checked' => false,
			'inside_method'     => null,
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

					if(!$_options['condition_checked'])
					{
						if($this->team_privacy === 'public')
						{

							switch ($this->rule)
							{
								case 'admin':
								case 'gateway':
									$result['card_action'] = true;
									break;
								case 'user':
									if($this->remote_user)
									{
										if(intval($value) === intval($this->user_id))
										{
											$result['card_action'] = true;
										}
									}

									if(!$this->show_another_status)
									{
										unset($_data['status']);
										unset($_data['last_time']);
									}

								default:
									if(!$this->show_another_status)
									{
										unset($_data['status']);
										unset($_data['last_time']);
									}
									break;
							}
						}
						elseif($this->team_privacy === 'team')
						{

							switch ($this->rule)
							{
								case 'admin':
								case 'gateway':
									$result['card_action'] = true;
									break;

								case 'user':
									if($this->remote_user)
									{
										if(intval($value) === intval($this->user_id))
										{
											$result['card_action'] = true;
										}

										if(!$this->show_another_status)
										{
											unset($_data['status']);
											unset($_data['last_time']);
										}
									}
									break;

								default:
									return false;
									break;
							}
						}
						elseif($this->team_privacy === 'private')
						{
							switch ($this->rule)
							{
								case 'admin':
								case 'gateway':
									$result['card_action'] = true;
									break;

								case 'user':
									if($this->remote_user)
									{
										if(intval($value) === intval($this->user_id))
										{
											$result['card_action'] = true;
										}
										else
										{
											return false;
										}
									}
									else
									{
										return false;
									}
									break;

								default:
									return false;
									break;
							}
						}
						else
						{
							return false;
						}
					}
					$result['user_id'] = \lib\utility\shortURL::encode($value);
					break;

				case 'fileurl':
					if($value)
					{
						$result['file'] = $this->host('file'). '/'. $value;
					}
					else
					{
						$result['file'] = $this->host('siftal_user');
					}

					break;

				case 'allowplus':
					$result['allow_plus'] = $value ? true : false;
					break;
				case 'allowminus':
					$result['allow_minus'] = $value ? true : false;
					break;

				case 'remote':
					$result['remote_user'] = $value ? true : false;
					break;

				case 'plus':
					$result[$key] = isset($value) ? (int) $value : null;
					break;
				case 'nationalcode':
					$result['national_code'] = isset($value) ? (string) $value : null;
					break;
				case 'marital':
					$result['marital'] = isset($value) ? $value : null;
					break;

				case 'childcount':
					$result['child'] = isset($value) ? $value : null;
					break;

				case 'birthplace':
					$result['birthcity'] = isset($value) ? $value : null;
					break;

				case 'from':
					$result['shfrom'] = isset($value) ? $value : null;
					break;

				case 'shcode':
					$result['shcode'] = isset($value) ? $value : null;
					break;

				case 'education':
					$result['education'] = isset($value) ? $value : null;
					break;

				case 'job':
					$result['job'] = isset($value) ? $value : null;
					break;

				case 'pasportcode':
					$result['passport_code'] = isset($value) ? $value : null;
					break;


				case 'cardnumber':
					$result['payment_account_number'] = isset($value) ? $value : null;
					break;

				case 'shaba':
					$result['shaba'] = isset($value) ? $value : null;
					break;



				case 'postion':
				case 'displayname':
				case 'firstname':
				case 'lastname':
				case 'rule':
				case 'telegram_id':
				case 'mobile':
				case 'status':
				case 'father':
				case 'birthday':
				case 'gender':
				case 'type':
					$result[$key] = isset($value) ? (string) $value : null;
					break;
				case 'visibility':
					$result[$key] = isset($value) ? (string) $value : null;
					if($_options['inside_method'] === 'view')
					{
						if($value === 'hidden')
						{
							return false;
						}
					}

					break;
				case 'personnelcode':
					$result['personnel_code'] = isset($value) ? (string) $value : null;
					break;

				case '24h':
					$result['24h'] = $value ? true : false;
					if(array_key_exists('date', $_data) && array_key_exists('start', $_data) && array_key_exists('end', $_data) && array_key_exists('enddate', $_data))
					{
						// the user is 24h
						if($value)
						{
							if($_data['end'])
							{
								$result['last_time_end'] = $_data['end'];
								$result['last_time'] = null;
							}
							else
							{
								$result['last_time'] = $_data['start'];
							}
						}
						else
						{
							if($_data['end'])
							{
								$result['last_time_end'] = $_data['enddate']. ' '. $_data['end'];
								$result['last_time'] = null;
							}
							else
							{
								if($_data['date'] == date("Y-m-d"))
								{
									$result['last_time'] = $_data['start'];
								}
								else
								{
									$result['last_time'] = null;
								}
							}

						}
					}
					break;
				case 'id':
				case 'team_id':
					$result[$key] = \lib\utility\shortURL::encode($value);
					break;

				case 'allowdescenter':
					$result['allow_desc_enter'] = $value ? true : false;
					break;

				case 'allowdescexit':
					$result['allow_desc_exit'] = $value ? true : false;
					break;

				default:
					continue;
					break;
			}
		}
		krsort($result);

		$result['present'] = false;
		if($result['visibility'] === 'hidden')
		{
			$result['live'] = 'hidden';
		}
		else
		{
			if($result['status'] === 'deactive')
			{
				$result['live'] = 'deactive';
			}
			else
			{
				if(isset($result['last_time']))
				{
					if($result['last_time'])
					{
						$result['live'] = 'on';
						$result['present'] = true;
					}
					else
					{
						$result['live'] = 'off';
					}
				}
				else
				{
					$result['live'] = 'off';
				}
			}
		}

		return $result;
	}
}
?>