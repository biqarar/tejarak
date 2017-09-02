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
			logs::set('api:member:user_id:notfound', $this->user_id, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		// get team and check it
		$team = utility::request('team');
		$team = utility\shortURL::decode($team);
		if(!$team)
		{
			logs::set('api:member:team:not:set', $this->user_id, $log_meta);
			debug::error(T_("Team not set"), 'user', 'permission');
			return false;
		}
		// load team data
		$team_detail = \lib\db\teams::access_team_id($team, $this->user_id, ['action' => 'add_member']);
		// check the team exist
		if(isset($team_detail['id']))
		{
			$team_id = $team_detail['id'];
		}
		else
		{
			logs::set('api:member:team:notfound:invalid', $this->user_id, $log_meta);
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

			// if(isset($old_user_id['rule']) && $old_user_id['rule'] === 'admin')
			// {
			// 	$user_id = $old_user_id['user_id'];
			// }
			// else
			if($old_user_id['mobile'])
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
			if(!in_array($rule, ['user', 'admin', 'gateway']))
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

		$visibility = utility::request('visibility');
		if($visibility)
		{
			if(!in_array($visibility, ['visible', 'hidden']))
			{
				logs::set('api:member:visibility:invalid', $this->user_id, $log_meta);
				debug::error(T_("Invalid parameter visibility"), 'visibility', 'arguments');
				return false;
			}
		}
		else
		{
			$visibility = 'visible';
		}

		// get status
		$status = utility::request('status');
		if($status)
		{
			if(!in_array($status, ['active', 'deactive', 'suspended']))
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

		$current_rule = (isset($old_user_id['rule'])) ? $old_user_id['rule'] : null;;
		if(($rule === 'user' && $current_rule === 'admin'))
		{
			$another_admin = \lib\db\teams::get_all_admins($team_id);

			if(count($another_admin) === 1)
			{
				logs::set('api:member:no:admin:in:team', $this->user_id, $log_meta);
				debug::error(T_("Only you are the team admin, You can not delete all admins"), 'rule', 'arguments');
				return false;
			}
		}

		$allowplus      = utility::isset_request('allow_plus') 		? utility::request('allow_plus') 		? 1 : 0 : null;
		$allowminus     = utility::isset_request('allow_minus')		? utility::request('allow_minus') 		? 1 : 0 : null;
		$is24h          = utility::isset_request('24h') 			? utility::request('24h') 				? 1 : 0 : null;
		$remote         = utility::isset_request('remote_user')		? utility::request('remote_user') 		? 1 : 0 : null;
		$isdefault      = utility::isset_request('is_default') 		? utility::request('is_default')		? 1 : 0 : null;
		$allowdescenter = utility::isset_request('allow_desc_enter')? utility::request('allow_desc_enter')	? 1 : 0 : null;
		$allowdescexit  = utility::isset_request('allow_desc_exit') ? utility::request('allow_desc_exit')	? 1 : 0 : null;

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


		$national_code = utility::request('national_code');
		if($national_code && mb_strlen($national_code) > 50)
		{
			logs::set('api:member:national_code:max:length', $this->user_id, $log_meta);
			debug::error(T_("You must set the national code less than 50 character"), 'national_code', 'arguments');
			return false;
		}

		$father = utility::request('father');
		if($father && mb_strlen($father) > 50)
		{
			logs::set('api:member:father:max:length', $this->user_id, $log_meta);
			debug::error(T_("You must set the father name less than 50 character"), 'father', 'arguments');
			return false;
		}

		$birthday      = utility::request('birthday');
		if($birthday && mb_strlen($birthday) > 50)
		{
			logs::set('api:member:birthday:max:length', $this->user_id, $log_meta);
			debug::error(T_("You must set the birthday name less than 50 character"), 'birthday', 'arguments');
			return false;
		}

		$gender        = utility::request('gender');
		if($gender && !in_array($gender, ['male', 'female']))
		{
			logs::set('api:member:gender:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid gender field"), 'gender', 'arguments');
			return false;
		}

		$type  = utility::request('type');
		if($type && !in_array($type, ['teacher','student', 'manager', 'deputy', 'janitor', 'organizer', 'sponsor']))
		{
			logs::set('api:member:type:max:length', $this->user_id, $log_meta);
			debug::error(T_("Invalid type of member"), 'type', 'arguments');
			return false;
		}


		// ready to insert userteam or userbranch record
		$args                  = [];
		$args['team_id']       = $team_id;
		$args['user_id']       = $user_id;
		$args['postion']       = trim($postion);
		$args['personnelcode'] = trim($personnelcode);
		$args['24h']           = $is24h;
		$args['remote']        = $remote;
		$args['isdefault']     = $isdefault;
		if($date_enter)
		{
			$args['dateenter']     = $date_enter;
		}
		$args['dateexit']       = trim($date_exit);
		$args['firstname']      = trim($firstname);
		$args['lastname']       = trim($lastname);
		$args['fileid']         = $file_id;
		$args['fileurl']        = $file_url;
		$args['allowplus']      = $allowplus;
		$args['allowminus']     = $allowminus;
		$args['status']         = $status;

		if($displayname)
		{
			$args['displayname']    = trim($displayname);
		}
		elseif($firstname || $lastname)
		{
			$args['displayname']    = trim($firstname. ' '. $lastname);
		}

		$args['rule']           = $rule;
		$args['visibility']     = $visibility;
		$args['allowdescenter'] = $allowdescenter;
		$args['allowdescexit']  = $allowdescexit;

		$args['nationalcode']   = trim($national_code);
		$args['father']         = trim($father);
		$args['birthday']       = trim($birthday);
		$args['gender']         = trim($gender);
		$args['type']           = trim($type);

		// check file is set or no
		// if file is not set and the user have a file load the default file
		if(!$args['fileid'] && !$args['fileurl'] && $_args['method'] === 'post')
		{
			$user_detail = \lib\db\users::get(['id' => $args['user_id'], 'limit' => 1]);
			if(isset($user_detail['user_file_id']))
			{
				$args['fileid'] = $user_detail['user_file_id'];
			}

			if(isset($user_detail['user_file_url']))
			{
				$args['fileurl'] = $user_detail['user_file_url'];
			}
		}

		// in insert new admin of team this admin can see the reports
		// to cancel this optino go to tejarak report settings to cancel
		// just in insert new admin set this option
		// no in update admin
		if($rule === 'admin' && $_args['method'] === 'post')
		{
			$args['reportdaily']     = 1;
			$args['reportenterexit'] = 1;
		}

		// insert new user team
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
			if(!utility::isset_request('postion')) 			unset($args['postion']);
			if(!utility::isset_request('personnel_code'))	unset($args['personnelcode']);
			if(!utility::isset_request('24h')) 				unset($args['24h']);
			if(!utility::isset_request('remote_user')) 		unset($args['remote']);
			if(!utility::isset_request('is_default')) 		unset($args['isdefault']);
			if(!utility::isset_request('date_enter')) 		unset($args['dateenter']);
			if(!utility::isset_request('date_exit')) 		unset($args['dateexit']);
			if(!utility::isset_request('firstname')) 		unset($args['firstname']);
			if(!utility::isset_request('lastname')) 		unset($args['lastname']);
			if(!utility::isset_request('file')) 			unset($args['fileid'], $args['fileurl']);
			if(!utility::isset_request('allow_plus')) 		unset($args['allowplus']);
			if(!utility::isset_request('allow_minus')) 		unset($args['allowminus']);
			if(!utility::isset_request('status')) 			unset($args['status']);
			if(!utility::isset_request('displayname')) 		unset($args['displayname']);
			if(!utility::isset_request('rule')) 			unset($args['rule']);
			if(!utility::isset_request('visibility')) 		unset($args['visibility']);
			if(!utility::isset_request('allow_desc_enter')) unset($args['allowdescenter']);
			if(!utility::isset_request('allow_desc_exit')) 	unset($args['allowdescexit']);

			if(!utility::isset_request('national_code')) 	unset($args['nationalcode']);
			if(!utility::isset_request('father')) 			unset($args['father']);
			if(!utility::isset_request('birthday')) 		unset($args['birthday']);
			if(!utility::isset_request('gender')) 			unset($args['gender']);
			if(!utility::isset_request('type')) 			unset($args['type']);

			// check barcode, qrcode and rfid,
			// update it if changed
			// get from utility::request()
			// check from $args
			$this->check_barcode($check_user_in_team['id']);
			// if have error in checking barcode
			if(!debug::$status)
			{
				return;
			}

			if(!empty($args))
			{
				\lib\db\userteams::update($args, $check_user_in_team['id']);
			}
		}
		elseif ($_args['method'] === 'delete')
		{
			// \lib\db\members::remove($args);
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



	/**
	 * check barcode, qrcode and rfid,
	 * update it if changed
	 * get from utility::request()
	 * check from $args
	 *
	 * @param      array  $_args  The arguments
	 */
	public function check_barcode($_id)
	{
			// set the log meta
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => utility::request(),
			]
		];

		$barcode1 = utility::request("barcode1");
		if($barcode1 && mb_strlen($barcode1) > 100)
		{
			logs::set('api:member:barcode:max:limit:barcode1', $this->user_id, $log_meta);
			debug::error(T_("You must set barcode less than 100 character"), 'barcode', 'arguments');
			return false;
		}

		if($barcode1 && mb_strlen($barcode1) < 3)
		{
			logs::set('api:member:barcode:min:limit:barcode1', $this->user_id, $log_meta);
			debug::error(T_("You must set barcode larger than 3 character"), 'barcode', 'arguments');
			return false;
		}

		$qrcode1 = utility::request("qrcode1");
		if($qrcode1 && mb_strlen($qrcode1) > 100)
		{
			logs::set('api:member:qrcode:max:limit:qrcode1', $this->user_id, $log_meta);
			debug::error(T_("You must set qrcode less than 100 character"), 'qrcode', 'arguments');
			return false;
		}

		if($qrcode1 && mb_strlen($qrcode1) < 3)
		{
			logs::set('api:member:qrcode:min:limit:qrcode1', $this->user_id, $log_meta);
			debug::error(T_("You must set qrcode larger than 3 character"), 'qrcode', 'arguments');
			return false;
		}

		$rfid1 = utility::request("rfid1");
		if($rfid1 && mb_strlen($rfid1) > 100)
		{
			logs::set('api:member:rfid:max:limit:rfid1', $this->user_id, $log_meta);
			debug::error(T_("You must set rfid less than 100 character"), 'rfid', 'arguments');
			return false;
		}

		if($rfid1 && mb_strlen($rfid1) < 3)
		{
			logs::set('api:member:rfid:min:limit:rfid1', $this->user_id, $log_meta);
			debug::error(T_("You must set rfid larger than 3 character"), 'rfid', 'arguments');
			return false;
		}

		$this->check_barcode_update($barcode1, $_id, 'barcode1');
		$this->check_barcode_update($qrcode1, $_id, 'qrcode1');
		$this->check_barcode_update($rfid1, $_id, 'rfid1');

	}


	/**
	 * check barcode exist and
	 * if not exist insert
	 * if exist update
	 * if no change return
	 *
	 * @param      <type>  $_barcode      The barcode
	 * @param      <type>  $_get_barcode  The get barcode
	 */
	public function check_barcode_update($_barcode, $_id, $_title)
	{
		$get_code =
		[
			'type'    => $_title,
			'id'      => $_id,
			'related' => 'userteams',
		];

		$check_exist_code = \lib\db\my_codes::get($get_code);

		if($_barcode)
		{
			// the code is not exist
			$set =
			[
				'code'    => $_barcode,
				'type'    => $_title,
				'related' => 'userteams',
				'id'      => $_id,
				'creator' => $this->user_id,
			];
			\lib\db\my_codes::set($set);
		}
		else
		{
			if($check_exist_code)
			{
				\lib\db\my_codes::remove($get_code);
			}
		}
	}
}
?>