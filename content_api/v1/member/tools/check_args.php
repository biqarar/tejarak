<?php
namespace content_api\v1\member\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait check_args
{
	public function check_args($_args, &$args, $_log_meta)
	{
		$log_meta = $_log_meta;

		// get firstname
		$displayname = utility::request("displayname");
		$displayname = trim($displayname);
		if($displayname && mb_strlen($displayname) > 50)
		{
			if($_args['save_log']) logs::set('api:member:displayname:max:length', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("You can set the displayname less than 50 character"), 'displayname', 'arguments');
			return false;
		}

		// get firstname
		$firstname = utility::request("firstname");
		$firstname = trim($firstname);
		if($firstname && mb_strlen($firstname) > 50)
		{
			if($_args['save_log']) logs::set('api:member:firstname:max:length', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("You can set the firstname less than 50 character"), 'firstname', 'arguments');
			return false;
		}

		// get lastname
		$lastname = utility::request("lastname");
		$lastname = trim($lastname);
		if($lastname && mb_strlen($lastname) > 50)
		{
			if($_args['save_log']) logs::set('api:member:lastname:max:length', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("You can set the lastname less than 50 character"), 'lastname', 'arguments');
			return false;
		}

		$postion     = utility::request('postion');
		if($postion && mb_strlen($postion) > 100)
		{
			if($_args['save_log']) logs::set('api:member:postion:max:length', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("You can set the postion less than 100 character"), 'postion', 'arguments');
			return false;
		}

		// get the code
		$personnelcode = utility::request('personnel_code');
		$personnelcode = trim($personnelcode);
		if($personnelcode && mb_strlen($personnelcode) > 9)
		{
			if($_args['save_log']) logs::set('api:member:code:max:length', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("You can set the personnel_code less than 9 character "), 'personnel_code', 'arguments');
			return false;
		}

		// get rule
		$rule = utility::request('rule');
		if($rule)
		{
			if(!in_array($rule, ['user', 'admin', 'gateway']))
			{
				if($_args['save_log']) logs::set('api:member:rule:invalid', $this->user_id, $log_meta);
				if($_args['debug']) debug::error(T_("Invalid parameter rule"), 'rule', 'arguments');
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
				if($_args['save_log']) logs::set('api:member:visibility:invalid', $this->user_id, $log_meta);
				if($_args['debug']) debug::error(T_("Invalid parameter visibility"), 'visibility', 'arguments');
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
				if($_args['save_log']) logs::set('api:member:status:invalid', $this->user_id, $log_meta);
				if($_args['debug']) debug::error(T_("Invalid parameter status"), 'status', 'arguments');
				return false;
			}
		}
		else
		{
			$status = 'active';
		}

		// get date enter
		$date_enter  = utility::request('date_enter');
		if($date_enter && \DateTime::createFromFormat('Y-m-d', $date_enter) === false)
		{
			if($_args['save_log']) logs::set('api:member:date_enter:invalid', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("Invalid date of date enter"), 'date_enter', 'arguments');
			return false;
		}

		// get date exit
		$date_exit   = utility::request('date_exit');
		if($date_exit && \DateTime::createFromFormat('Y-m-d', $date_exit) === false)
		{
			if($_args['save_log']) logs::set('api:member:date_exit:invalid', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("Invalid date of date exit"), 'date_exit', 'arguments');
			return false;
		}

		// get file code
		$file_code = utility::request('file');
		$file_id   = null;
		$fileurl  = null;
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
				elseif(isset($logo_record['meta']['url']))
				{
					$fileurl = $logo_record['meta']['url'];
				}
			}
			else
			{
				$file_id = null;
			}
		}


		$allowplus      = utility::isset_request('allow_plus') 		? utility::request('allow_plus') 		? 1 : 0 : null;
		$allowminus     = utility::isset_request('allow_minus')		? utility::request('allow_minus') 		? 1 : 0 : null;
		$is24h          = utility::isset_request('24h') 			? utility::request('24h') 				? 1 : 0 : null;
		$remote         = utility::isset_request('remote_user')		? utility::request('remote_user') 		? 1 : 0 : null;
		$isdefault      = utility::isset_request('is_default') 		? utility::request('is_default')		? 1 : 0 : null;
		$allowdescenter = utility::isset_request('allow_desc_enter')? utility::request('allow_desc_enter')	? 1 : 0 : null;
		$allowdescexit  = utility::isset_request('allow_desc_exit') ? utility::request('allow_desc_exit')	? 1 : 0 : null;

		$national_code = utility::request('national_code');
		if($national_code && mb_strlen($national_code) > 50)
		{
			if($_args['save_log']) logs::set('api:member:national_code:max:length', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("You must set the national code less than 50 character"), 'national_code', 'arguments');
			return false;
		}

		$father = utility::request('father');
		if($father && mb_strlen($father) > 50)
		{
			if($_args['save_log']) logs::set('api:member:father:max:length', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("You must set the father name less than 50 character"), 'father', 'arguments');
			return false;
		}

		$birthday      = utility::request('birthday');
		if($birthday && mb_strlen($birthday) > 50)
		{
			if($_args['save_log']) logs::set('api:member:birthday:max:length', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("You must set the birthday name less than 50 character"), 'birthday', 'arguments');
			return false;
		}

		$gender        = utility::request('gender');
		if($gender && !in_array($gender, ['male', 'female']))
		{
			if($_args['save_log']) logs::set('api:member:gender:invalid', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("Invalid gender field"), 'gender', 'arguments');
			return false;
		}

		$type  = utility::request('type');
		if($type && !in_array($type, ['teacher','student','manager','deputy','janitor','organizer','sponsor', 'takenunit_teacher', 'takenunit_student']))
		{
			if($_args['save_log']) logs::set('api:member:type:max:length', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("Invalid type of member"), 'type', 'arguments');
			return false;
		}


		$marital                = utility::request('marital');
		if($marital && !in_array($marital, ['single', 'married']))
		{
			if($_args['save_log']) logs::set('api:userteam:marital:invalid', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("Invalid marital field"), 'marital', 'arguments');
			return false;
		}

		$child                  = utility::request('child');
		if($child && mb_strlen($child) > 50)
		{
			if($_args['save_log']) logs::set('api:userteam:child:max:lenght', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("You must set the child less than 50 character"), 'child', 'arguments');
			return false;
		}

		$brithcity              = utility::request('brithcity');
		if($brithcity && mb_strlen($brithcity) > 50)
		{
			if($_args['save_log']) logs::set('api:userteam:brithcity:max:lenght', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("You must set the brithcity less than 50 character"), 'brithcity', 'arguments');
			return false;
		}

		$shfrom                 = utility::request('shfrom');
		if($shfrom && mb_strlen($shfrom) > 50)
		{
			if($_args['save_log']) logs::set('api:userteam:shfrom:max:lenght', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("You must set the shfrom less than 50 character"), 'shfrom', 'arguments');
			return false;
		}

		$shcode                 = utility::request('shcode');
		if($shcode && mb_strlen($shcode) > 50)
		{
			if($_args['save_log']) logs::set('api:userteam:shcode:max:lenght', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("You must set the shcode less than 50 character"), 'shcode', 'arguments');
			return false;
		}

		$education              = utility::request('education');
		if($education && mb_strlen($education) > 50)
		{
			if($_args['save_log']) logs::set('api:userteam:education:max:lenght', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("You must set the education less than 50 character"), 'education', 'arguments');
			return false;
		}

		$job       = utility::request('job');
		if($job && mb_strlen($job) > 50)
		{
			if($_args['save_log']) logs::set('api:userteam:job:max:lenght', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("You must set the job less than 50 character"), 'job', 'arguments');
			return false;
		}

		$passport_code          = utility::request('passport_code');
		if($passport_code && mb_strlen($passport_code) > 50)
		{
			if($_args['save_log']) logs::set('api:userteam:passport_code:max:lenght', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("You must set the passport_code less than 50 character"), 'passport_code', 'arguments');
			return false;
		}

		// $passport_expire        = utility::request('passport_expire');
		// if($passport_expire && mb_strlen($passport_expire) > 50)
		// {
		// 	if($_args['save_log']) logs::set('api:userteam:passport_expire:max:lenght', $this->user_id, $log_meta);
		// 	if($_args['debug']) debug::error(T_("You must set the passport_expire less than 50 character"), 'passport_expire', 'arguments');
		// 	return false;
		// }

		$payment_account_number = utility::request('payment_account_number');
		if($payment_account_number && mb_strlen($payment_account_number) > 50)
		{
			if($_args['save_log']) logs::set('api:userteam:payment_account_number:max:lenght', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("You must set the payment_account_number less than 50 character"), 'payment_account_number', 'arguments');
			return false;
		}

		$shaba                  = utility::request('shaba');
		if($shaba && mb_strlen($shaba) > 50)
		{
			if($_args['save_log']) logs::set('api:userteam:shaba:max:lenght', $this->user_id, $log_meta);
			if($_args['debug']) debug::error(T_("You must set the shaba less than 50 character"), 'shaba', 'arguments');
			return false;
		}

		$current_rule = (isset($this->old_user_id['rule'])) ? $this->old_user_id['rule'] : null;
		if(($rule === 'user' && $current_rule === 'admin'))
		{
			$another_admin = \lib\db\teams::get_all_admins($team_id);

			if(count($another_admin) === 1)
			{
				if($_args['save_log']) logs::set('api:member:no:admin:in:team', $this->user_id, $log_meta);
				if($_args['debug']) debug::error(T_("Only you are the team admin, You can not delete all admins"), 'rule', 'arguments');
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
		$args['brithplace']     = $brithcity;
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
		$args['fileurl']        = $fileurl;

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