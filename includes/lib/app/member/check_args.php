<?php
namespace lib\app\member;


trait check_args
{
	public static function check_args($_args, &$args, $_log_meta, $_team_id)
	{
		$log_meta = $_log_meta;

		// get firstname
		$displayname = \dash\app::request("displayname");
		$displayname = trim($displayname);
		if($displayname && mb_strlen($displayname) > 50)
		{
			if($_args['save_log']) \dash\db\logs::set('api:member:displayname:max:length', \dash\user::id(), $log_meta);
			if($_args['debug']) \dash\notif::error(T_("You can set the displayname less than 50 character"), 'displayname', 'arguments');
			return false;
		}

		// get firstname
		$firstname = \dash\app::request("firstname");
		$firstname = trim($firstname);
		if($firstname && mb_strlen($firstname) > 50)
		{
			if($_args['save_log']) \dash\db\logs::set('api:member:firstname:max:length', \dash\user::id(), $log_meta);
			if($_args['debug']) \dash\notif::error(T_("You can set the firstname less than 50 character"), 'firstname', 'arguments');
			return false;
		}

		// get lastname
		$lastname = \dash\app::request("lastname");
		$lastname = trim($lastname);
		if($lastname && mb_strlen($lastname) > 50)
		{
			if($_args['save_log']) \dash\db\logs::set('api:member:lastname:max:length', \dash\user::id(), $log_meta);
			if($_args['debug']) \dash\notif::error(T_("You can set the lastname less than 50 character"), 'lastname', 'arguments');
			return false;
		}

		$postion     = \dash\app::request('postion');
		if($postion && mb_strlen($postion) > 100)
		{
			if($_args['save_log']) \dash\db\logs::set('api:member:postion:max:length', \dash\user::id(), $log_meta);
			if($_args['debug']) \dash\notif::error(T_("You can set the postion less than 100 character"), 'postion', 'arguments');
			return false;
		}

		// get the code
		$personnelcode = \dash\app::request('personnel_code');
		$personnelcode = trim($personnelcode);
		if($personnelcode && mb_strlen($personnelcode) > 9)
		{
			if($_args['save_log']) \dash\db\logs::set('api:member:code:max:length', \dash\user::id(), $log_meta);
			if($_args['debug']) \dash\notif::error(T_("You can set the personnel_code less than 9 character "), 'personnel_code', 'arguments');
			return false;
		}

		// get rule
		$rule = \dash\app::request('rule');
		if($rule)
		{
			if(!in_array($rule, ['user', 'admin', 'gateway']))
			{
				if($_args['save_log']) \dash\db\logs::set('api:member:rule:invalid', \dash\user::id(), $log_meta);
				if($_args['debug']) \dash\notif::error(T_("Invalid parameter rule"), 'rule', 'arguments');
				return false;
			}
		}
		elseif($_args['method'] === 'post')
		{
			$rule = 'user';
		}

		$visibility = \dash\app::request('visibility');
		if($visibility)
		{
			if(!in_array($visibility, ['visible', 'hidden']))
			{
				if($_args['save_log']) \dash\db\logs::set('api:member:visibility:invalid', \dash\user::id(), $log_meta);
				if($_args['debug']) \dash\notif::error(T_("Invalid parameter visibility"), 'visibility', 'arguments');
				return false;
			}
		}
		elseif($_args['method'] === 'post')
		{
			$visibility = 'visible';
		}

		// get status
		$status = \dash\app::request('status');
		if($status)
		{
			if(!in_array($status, ['active', 'deactive', 'suspended']))
			{
				if($_args['save_log']) \dash\db\logs::set('api:member:status:invalid', \dash\user::id(), $log_meta);
				if($_args['debug']) \dash\notif::error(T_("Invalid parameter status"), 'status', 'arguments');
				return false;
			}
		}
		elseif($_args['method'] === 'post')
		{
			$status = 'active';
		}

		// get date enter
		$date_enter  = \dash\app::request('date_enter');
		if($date_enter && \DateTime::createFromFormat('Y-m-d', $date_enter) === false)
		{
			if($_args['save_log']) \dash\db\logs::set('api:member:date_enter:invalid', \dash\user::id(), $log_meta);
			if($_args['debug']) \dash\notif::error(T_("Invalid date of date enter"), 'date_enter', 'arguments');
			return false;
		}

		// get date exit
		$date_exit   = \dash\app::request('date_exit');
		if($date_exit && \DateTime::createFromFormat('Y-m-d', $date_exit) === false)
		{
			if($_args['save_log']) \dash\db\logs::set('api:member:date_exit:invalid', \dash\user::id(), $log_meta);
			if($_args['debug']) \dash\notif::error(T_("Invalid date of date exit"), 'date_exit', 'arguments');
			return false;
		}

		// get file code
		$file_code = \dash\app::request('file');
		$file_id   = null;
		$avatar  = null;
		if($file_code)
		{
			$file_id = \dash\coding::decode($file_code);
			if($file_id)
			{
				$logo_record = \dash\db\posts::is_attachment($file_id);
				if(!$logo_record)
				{
					$file_id = null;
				}
				elseif(isset($logo_record['meta']['url']))
				{
					$avatar = $logo_record['meta']['url'];
				}
			}
			else
			{
				$file_id = null;
			}
		}


		$allowplus      = \dash\app::isset_request('allow_plus') 		? \dash\app::request('allow_plus') 		? 1 : 0 : null;
		$allowminus     = \dash\app::isset_request('allow_minus')		? \dash\app::request('allow_minus') 		? 1 : 0 : null;
		$is24h          = \dash\app::isset_request('24h') 			? \dash\app::request('24h') 				? 1 : 0 : null;
		$remote         = \dash\app::isset_request('remote_user')		? \dash\app::request('remote_user') 		? 1 : 0 : null;
		$isdefault      = \dash\app::isset_request('is_default') 		? \dash\app::request('is_default')		? 1 : 0 : null;
		$allowdescenter = \dash\app::isset_request('allow_desc_enter')? \dash\app::request('allow_desc_enter')	? 1 : 0 : null;
		$allowdescexit  = \dash\app::isset_request('allow_desc_exit') ? \dash\app::request('allow_desc_exit')	? 1 : 0 : null;

		$national_code = \dash\app::request('national_code');
		if($national_code && mb_strlen($national_code) > 50)
		{
			if($_args['save_log']) \dash\db\logs::set('api:member:national_code:max:length', \dash\user::id(), $log_meta);
			if($_args['debug']) \dash\notif::error(T_("You must set the national code less than 50 character"), 'national_code', 'arguments');
			return false;
		}

		$father = \dash\app::request('father');
		if($father && mb_strlen($father) > 50)
		{
			if($_args['save_log']) \dash\db\logs::set('api:member:father:max:length', \dash\user::id(), $log_meta);
			if($_args['debug']) \dash\notif::error(T_("You must set the father name less than 50 character"), 'father', 'arguments');
			return false;
		}

		$birthday      = \dash\app::request('birthday');
		if($birthday && mb_strlen($birthday) > 50)
		{
			if($_args['save_log']) \dash\db\logs::set('api:member:birthday:max:length', \dash\user::id(), $log_meta);
			if($_args['debug']) \dash\notif::error(T_("You must set the birthday name less than 50 character"), 'birthday', 'arguments');
			return false;
		}

		$gender        = \dash\app::request('gender');
		if($gender && !in_array($gender, ['male', 'female']))
		{
			if($_args['save_log']) \dash\db\logs::set('api:member:gender:invalid', \dash\user::id(), $log_meta);
			if($_args['debug']) \dash\notif::error(T_("Invalid gender field"), 'gender', 'arguments');
			return false;
		}

		$type  = \dash\app::request('type');
		if($type && !in_array($type, ['teacher','student','manager','deputy','janitor','organizer','sponsor', 'takenunit_teacher', 'takenunit_student']))
		{
			if($_args['save_log']) \dash\db\logs::set('api:member:type:max:length', \dash\user::id(), $log_meta);
			if($_args['debug']) \dash\notif::error(T_("Invalid type of member"), 'type', 'arguments');
			return false;
		}


		$marital                = \dash\app::request('marital');
		if($marital && !in_array($marital, ['single', 'married']))
		{
			if($_args['save_log']) \dash\db\logs::set('api:userteam:marital:invalid', \dash\user::id(), $log_meta);
			if($_args['debug']) \dash\notif::error(T_("Invalid marital field"), 'marital', 'arguments');
			return false;
		}

		$child                  = \dash\app::request('child');
		if($child && mb_strlen($child) > 50)
		{
			if($_args['save_log']) \dash\db\logs::set('api:userteam:child:max:lenght', \dash\user::id(), $log_meta);
			if($_args['debug']) \dash\notif::error(T_("You must set the child less than 50 character"), 'child', 'arguments');
			return false;
		}

		$birthcity              = \dash\app::request('birthcity');
		if($birthcity && mb_strlen($birthcity) > 50)
		{
			if($_args['save_log']) \dash\db\logs::set('api:userteam:birthcity:max:lenght', \dash\user::id(), $log_meta);
			if($_args['debug']) \dash\notif::error(T_("You must set the birthcity less than 50 character"), 'birthcity', 'arguments');
			return false;
		}

		$shfrom                 = \dash\app::request('shfrom');
		if($shfrom && mb_strlen($shfrom) > 50)
		{
			if($_args['save_log']) \dash\db\logs::set('api:userteam:shfrom:max:lenght', \dash\user::id(), $log_meta);
			if($_args['debug']) \dash\notif::error(T_("You must set the shfrom less than 50 character"), 'shfrom', 'arguments');
			return false;
		}

		$shcode                 = \dash\app::request('shcode');
		if($shcode && mb_strlen($shcode) > 50)
		{
			if($_args['save_log']) \dash\db\logs::set('api:userteam:shcode:max:lenght', \dash\user::id(), $log_meta);
			if($_args['debug']) \dash\notif::error(T_("You must set the shcode less than 50 character"), 'shcode', 'arguments');
			return false;
		}

		$education              = \dash\app::request('education');
		if($education && mb_strlen($education) > 50)
		{
			if($_args['save_log']) \dash\db\logs::set('api:userteam:education:max:lenght', \dash\user::id(), $log_meta);
			if($_args['debug']) \dash\notif::error(T_("You must set the education less than 50 character"), 'education', 'arguments');
			return false;
		}

		$job       = \dash\app::request('job');
		if($job && mb_strlen($job) > 50)
		{
			if($_args['save_log']) \dash\db\logs::set('api:userteam:job:max:lenght', \dash\user::id(), $log_meta);
			if($_args['debug']) \dash\notif::error(T_("You must set the job less than 50 character"), 'job', 'arguments');
			return false;
		}

		$passport_code          = \dash\app::request('passport_code');
		if($passport_code && mb_strlen($passport_code) > 50)
		{
			if($_args['save_log']) \dash\db\logs::set('api:userteam:passport_code:max:lenght', \dash\user::id(), $log_meta);
			if($_args['debug']) \dash\notif::error(T_("You must set the passport_code less than 50 character"), 'passport_code', 'arguments');
			return false;
		}

		// $passport_expire        = \dash\app::request('passport_expire');
		// if($passport_expire && mb_strlen($passport_expire) > 50)
		// {
		// 	if($_args['save_log']) \dash\db\logs::set('api:userteam:passport_expire:max:lenght', \dash\user::id(), $log_meta);
		// 	if($_args['debug']) \dash\notif::error(T_("You must set the passport_expire less than 50 character"), 'passport_expire', 'arguments');
		// 	return false;
		// }

		$payment_account_number = \dash\app::request('payment_account_number');
		if($payment_account_number && mb_strlen($payment_account_number) > 50)
		{
			if($_args['save_log']) \dash\db\logs::set('api:userteam:payment_account_number:max:lenght', \dash\user::id(), $log_meta);
			if($_args['debug']) \dash\notif::error(T_("You must set the payment_account_number less than 50 character"), 'payment_account_number', 'arguments');
			return false;
		}

		$shaba                  = \dash\app::request('shaba');
		if($shaba && mb_strlen($shaba) > 50)
		{
			if($_args['save_log']) \dash\db\logs::set('api:userteam:shaba:max:lenght', \dash\user::id(), $log_meta);
			if($_args['debug']) \dash\notif::error(T_("You must set the shaba less than 50 character"), 'shaba', 'arguments');
			return false;
		}

		$current_rule = (isset(self::$old_user_id['rule'])) ? self::$old_user_id['rule'] : null;
		if(($rule === 'user' && $current_rule === 'admin'))
		{
			$another_admin = \lib\db\teams::get_all_admins($_team_id);

			if(count($another_admin) === 1)
			{
				if($_args['save_log']) \dash\db\logs::set('api:member:no:admin:in:team', \dash\user::id(), $log_meta);
				if($_args['debug']) \dash\notif::error(T_("Only you are the team admin, You can not delete all admins"), 'rule', 'arguments');
				return false;
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


		$args['marital']        = $marital;
		$args['childcount']     = $child;
		$args['birthplace']     = $birthcity;
		$args['from']           = $shfrom;
		$args['shcode']         = $shcode;
		$args['education']      = $education;
		$args['job']            = $job;
		$args['pasportcode']    = $passport_code;

		$args['cardnumber']     = $payment_account_number;
		$args['shaba']          = $shaba;


		$args['nationalcode']   = trim($national_code);
		$args['father']         = trim($father);
		$args['birthday']       = trim($birthday);
		$args['gender']         = trim($gender);
		$args['type']           = trim($type);
		$args['24h']            = $is24h;
		$args['remote']         = $remote;
		$args['isdefault']      = $isdefault;
		$args['allowplus']      = $allowplus;
		$args['allowminus']     = $allowminus;
		$args['allowdescenter'] = $allowdescenter;
		$args['allowdescexit']  = $allowdescexit;

		$args['postion']       = trim($postion);
		$args['personnelcode'] = trim($personnelcode);
		if($date_enter)
		{
			$args['dateenter']     = $date_enter;
		}
		$args['dateexit']       = trim($date_exit);
		$args['firstname']      = trim($firstname);
		$args['lastname']       = trim($lastname);
		$args['fileid']         = $file_id;
		$args['avatar']        = $avatar;

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
	}
}
?>