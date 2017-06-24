<?php
namespace content_api\v1\member\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait add
{


	/**
	 * Adds a member.
	 *
	 * @param      array    $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function add_member($_args = [])
	{
		// default args
		$default_args =
		[
			'method' => 'post'
		];

		if(!is_array($_args))
		{
			$_args = [];
		}
		// merge default args and args
		$_args = array_merge($default_args, $_args);

		// set default title of debug
		debug::title(T_("Operation Faild"));

		// delete member mode
		$delete_mode = false;

		// set the log meta
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => utility::request(),
			]
		];

		// check user id is exist
		if(!$this->user_id)
		{
			logs::set('api:member:user_id:notfound', null, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		// get team and check it
		$team = utility::request('team');
		$team = utility\shortURL::decode($team);
		if(!$team)
		{
			logs::set('api:member:team:not:set', null, $log_meta);
			debug::error(T_("Team not set"), 'user', 'permission');
			return false;
		}
		// load team data
		$team_detail = \lib\db\teams::access_team_id($team, $this->user_id, 'add:member');
		// check the team exist
		if(isset($team_detail['id']))
		{
			$team_id = $team_detail['id'];
		}
		else
		{
			logs::set('api:member:team:notfound:invalid', null, $log_meta);
			debug::error(T_("Team not found"), 'user', 'permission');
			return false;
		}

		// get firstname
		$displayname = utility::request("displayname");
		$displayname = trim($displayname);
		if($displayname && mb_strlen($displayname) > 50)
		{
			logs::set('api:member:displayname:max:length', $this->user_id, $log_meta);
			debug::error(T_("You can set the displayname less than 50 character"), 'displayname', 'arguments');
			return false;
		}

		// get firstname
		$firstname = utility::request("firstname");
		$firstname = trim($firstname);
		if($firstname && mb_strlen($firstname) > 50)
		{
			logs::set('api:member:firstname:max:length', $this->user_id, $log_meta);
			debug::error(T_("You can set the firstname less than 50 character"), 'firstname', 'arguments');
			return false;
		}

		// get lastname
		$lastname = utility::request("lastname");
		$lastname = trim($lastname);
		if($lastname && mb_strlen($lastname) > 50)
		{
			logs::set('api:member:lastname:max:length', $this->user_id, $log_meta);
			debug::error(T_("You can set the lastname less than 50 character"), 'lastname', 'arguments');
			return false;
		}

		// get mobile of user
		$mobile           = utility::request("mobile");
		$mobile_syntax    = \lib\utility\filter::mobile($mobile);
		$check_user_exist = null;
		if($mobile && !$mobile_syntax)
		{
			logs::set('api:member:mobile:not:set', $this->user_id, $log_meta);
			debug::error(T_("Invalid mobile number"), 'mobile', 'arguments');
			return false;
		}
		elseif($mobile && $mobile_syntax && ctype_digit($mobile))
		{
			$mobile = $mobile_syntax;
		}
		else
		{
			$mobile_syntax = $mobile = null;
		}

		/**
		 ****************************************************************************
		 * find user id
		 *
		 * @var        <type>
		 */
		$user_id = null;
		// check userid exist in userteam by this team
		$check_not_duplicate_userteam = false;
		// post to add new member
		if($_args['method'] === 'post')
		{
			// mobile is set
			if($mobile)
			{
				$check_user_exist = \lib\db\users::get_by_mobile($mobile);
				// the mobile was exist
				if(isset($check_user_exist['id']))
				{
					$user_id = $check_user_exist['id'];
				}
				else
				{
					// we need to get user id to insert new record of userteams
					// signup empty to get user id
					$signup =
					[
						'user_mobile'      => $mobile,
						'user_pass'        => null,
						'user_displayname' => null,
						'user_createdate'  => date("Y-m-d H:i:s"),
					];

					\lib\db\users::insert($signup);
					$user_id = \lib\db::insert_id();
				}
			}
			else
			{
				// we need to get user id to insert new record of userteams
				// signup empty to get user id
				$signup =
				[
					'user_mobile'      => null,
					'user_pass'        => null,
					'user_displayname' => null,
					'user_createdate'  => date("Y-m-d H:i:s"),
				];

				\lib\db\users::insert($signup);
				$user_id = \lib\db::insert_id();
			}
		}
		elseif($_args['method'] === 'patch')
		{
			$request_user_id = utility::request('id');
			if($request_user_id && $request_user_id = utility\shortURL::decode($request_user_id))
			{
				$old_user_id = \lib\db\userteams::get_list(['user_id' => $request_user_id,'team_id' => $team_id, 'limit' => 1]);
				if(!isset($old_user_id['user_id']) || !array_key_exists('mobile', $old_user_id))
				{
					logs::set('api:member:user_id:not:invalid:patch', $this->user_id, $log_meta);
					debug::error(T_("Invalid user id"), 'user', 'system');
					return false;
				}
			}
			else
			{
				logs::set('api:member:user_id:not:set:patch', $this->user_id, $log_meta);
				debug::error(T_("User id not set"), 'user', 'system');
				return false;
			}

			if(isset($old_user_id['rule']) && $old_user_id['rule'] === 'admin')
			{
				$user_id = $old_user_id['user_id'];
			}
			elseif($old_user_id['mobile'])
			{
				if($mobile)
				{
					if($mobile == $old_user_id['mobile'])
					{
						$user_id = $old_user_id['user_id'];
					}
					else
					{
						$check_user_exist = \lib\db\users::get_by_mobile($mobile);
						// the mobile was exist
						if(isset($check_user_exist['id']))
						{
							$user_id = $check_user_exist['id'];
							$check_not_duplicate_userteam = true;
						}
						else
						{
							// we need to get user id to insert new record of userteams
							// signup empty to get user id
							$signup =
							[
								'user_mobile'      => $mobile,
								'user_pass'        => null,
								'user_displayname' => null,
								'user_createdate'  => date("Y-m-d H:i:s"),
							];

							\lib\db\users::insert($signup);
							$user_id = \lib\db::insert_id();
						}
					}

				}
				else
				{
					// the user remove mobile
					// signup empty to get user id
					$signup =
					[
						'user_mobile'      => null,
						'user_pass'        => null,
						'user_displayname' => null,
						'user_createdate'  => date("Y-m-d H:i:s"),
					];

					\lib\db\users::insert($signup);
					$user_id = \lib\db::insert_id();
				}
			}
			else
			{
				if($mobile)
				{
					// unreachable old user id
					\lib\db\users::update(['user_status' => 'unreachable'], $old_user_id['user_id']);

					$check_user_exist = \lib\db\users::get_by_mobile($mobile);
					// the mobile was exist
					if(isset($check_user_exist['id']))
					{
						$user_id = $check_user_exist['id'];
						$check_not_duplicate_userteam = true;
					}
					else
					{
						// we need to get user id to insert new record of userteams
						// signup empty to get user id
						$signup =
						[
							'user_mobile'      => $mobile,
							'user_pass'        => null,
							'user_displayname' => null,
							'user_createdate'  => date("Y-m-d H:i:s"),
						];

						\lib\db\users::insert($signup);
						$user_id = \lib\db::insert_id();
					}
				}
				else
				{
					$user_id = $old_user_id['user_id'];
				}
			}
		}

		/**
		 * end find userid
		 ****************************************************************************
		 */

		if(!$user_id)
		{
			logs::set('api:member:user_id:not:found:and:cannot:signup', $this->user_id, $log_meta);
			debug::error(T_("User id not found"), 'user', 'system');
			return false;
		}
		// to redirect site in new url
		\lib\storage::set_new_user_code(utility\shortURL::encode($user_id));

		if($check_not_duplicate_userteam)
		{
			$userteam_record = \lib\db\userteams::get(['user_id' => $user_id, 'team_id' => $team_id, 'limit' => 1]);
			if($userteam_record)
			{
				logs::set('api:member:duplicate:user:team', $this->user_id, $log_meta);
				debug::error(T_("This user was already added to this team"), 'mobile', 'arguments');
				return false;
			}
		}

		// get postion
		$postion     = utility::request('postion');
		if($postion && mb_strlen($postion) > 100)
		{
			logs::set('api:member:postion:max:length', $this->user_id, $log_meta);
			debug::error(T_("You can set the postion less than 100 character"), 'postion', 'arguments');
			return false;
		}

		// get the code
		$personnelcode = utility::request('personnel_code');
		$personnelcode = trim($personnelcode);
		if($personnelcode && mb_strlen($personnelcode) > 9)
		{
			logs::set('api:member:code:max:length', $this->user_id, $log_meta);
			debug::error(T_("You can set the personnel_code less than 9 character "), 'personnel_code', 'arguments');
			return false;
		}

		// get rule
		$rule = utility::request('rule');
		if($rule)
		{
			if(!in_array($rule, ['user', 'admin']))
			{
				logs::set('api:member:rule:invalid', $this->user_id, $log_meta);
				debug::error(T_("Invalid parameter rule"), 'rule', 'arguments');
				return false;
			}
		}
		else
		{
			$rule = 'user';
		}

		// get status
		$status = utility::request('status');
		if($status)
		{
			if(!in_array($status, ['active', 'deactive', 'disable']))
			{
				logs::set('api:member:status:invalid', $this->user_id, $log_meta);
				debug::error(T_("Invalid parameter status"), 'status', 'arguments');
				return false;
			}
		}
		else
		{
			$status = 'active';
		}

		$allowplus  = utility::isset_request('allow_plus') 	? utility::request('allow_plus') 	? 1 : 0 : null;
		$allowminus = utility::isset_request('allow_minus')	? utility::request('allow_minus') 	? 1 : 0 : null;
		$is24h      = utility::isset_request('24h') 		? utility::request('24h') 			? 1 : 0 : null;
		$remote     = utility::isset_request('remote_user')		? utility::request('remote_user') 	? 1 : 0 : null;
		$isdefault  = utility::isset_request('is_default') 	? utility::request('is_default')	? 1 : 0 : null;

		// get date enter
		$date_enter  = utility::request('date_enter');
		if($date_enter && \DateTime::createFromFormat('Y-m-d', $date_enter) === false)
		{
			logs::set('api:member:date_enter:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid date of date enter"), 'date_enter', 'arguments');
			return false;
		}

		// get date exit
		$date_exit   = utility::request('date_exit');
		if($date_exit && \DateTime::createFromFormat('Y-m-d', $date_exit) === false)
		{
			logs::set('api:member:date_exit:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid date of date exit"), 'date_exit', 'arguments');
			return false;
		}

		// get file code
		$file_code = utility::request('file');
		$file_id   = null;
		$file_url  = null;
		if($file_code)
		{
			$file_id = \lib\utility\shortURL::decode($file_code);
			if($file_id)
			{
				$logo_record = \lib\db\posts::is_attachment($file_id);
				if(!$logo_record)
				{
					$file_id = null;
				}
				elseif(isset($logo_record['post_meta']['url']))
				{
					$file_url = $logo_record['post_meta']['url'];
				}
			}
			else
			{
				$file_id = null;
			}
		}

		// ready to insert userteam or userbranch record
		$args                  = [];
		$args['team_id']       = $team_id;
		$args['user_id']       = $user_id;
		$args['postion']       = $postion;
		$args['personnelcode'] = $personnelcode;
		$args['24h']           = $is24h;
		$args['remote']        = $remote;
		$args['isdefault']     = $isdefault;
		if($date_enter)
		{
			$args['dateenter']     = $date_enter;
		}
		$args['dateexit']      = $date_exit;
		$args['firstname']     = $firstname;
		$args['lastname']      = $lastname;
		$args['fileid']        = $file_id;
		$args['fileurl']       = $file_url;
		$args['allowplus']     = $allowplus;
		$args['allowminus']    = $allowminus;
		$args['status']        = $status;
		$args['displayname']   = $displayname;
		$args['rule']          = $rule;

		if($_args['method'] === 'post')
		{
			\lib\db\userteams::insert($args);
		}
		elseif($_args['method'] === 'patch')
		{
			$id = utility::request('id');
			$id = utility\shortURL::decode($id);
			if(!$id)
			{
				logs::set('api:member:pathc:id:not:set', $this->user_id, $log_meta);
				debug::error(T_("Id not set"), 'id', 'arguments');
				return false;
			}

			$check_user_in_team = \lib\db\userteams::get(['user_id' => $id, 'team_id' => $team_id, 'limit' => 1]);

			if(!$check_user_in_team || !isset($check_user_in_team['id']))
			{
				logs::set('api:member:user:not:in:team', $this->user_id, $log_meta);
				debug::error(T_("This user is not in this team"), 'id', 'arguments');
				return false;
			}

			unset($args['team_id']);
			if(!utility::isset_request('postion')) 		unset($args['postion']);
			if(!utility::isset_request('personnel_code'))unset($args['personnelcode']);
			if(!utility::isset_request('24h')) 			unset($args['24h']);
			if(!utility::isset_request('remote_user')) 	unset($args['remote']);
			if(!utility::isset_request('is_default')) 	unset($args['isdefault']);
			if(!utility::isset_request('date_enter')) 	unset($args['dateenter']);
			if(!utility::isset_request('date_exit')) 	unset($args['dateexit']);
			if(!utility::isset_request('firstname')) 	unset($args['firstname']);
			if(!utility::isset_request('lastname')) 	unset($args['lastname']);
			if(!utility::isset_request('file')) 		unset($args['fileid'], $args['fileurl']);
			if(!utility::isset_request('allow_plus')) 	unset($args['allowplus']);
			if(!utility::isset_request('allow_minus')) 	unset($args['allowminus']);
			if(!utility::isset_request('status')) 		unset($args['status']);
			if(!utility::isset_request('displayname')) 	unset($args['displayname']);
			if(!utility::isset_request('rule')) 		unset($args['rule']);

			if(!empty($args))
			{
				\lib\db\userteams::update($args, $check_user_in_team['id']);
			}
		}
		elseif ($_args['method'] === 'delete')
		{
			\lib\db\members::remove($args);
		}

		if(debug::$status)
		{
			debug::title(T_("Operation Complete"));

			if($_args['method'] === 'post')
			{
				debug::true(T_("Member successfully added"));
			}
			elseif($_args['method'] === 'patch')
			{
				debug::true(T_("Member successfully updated"));
			}
			else
			{
				debug::true(T_("Member successfully removed"));
			}
		}

	}
}
?>