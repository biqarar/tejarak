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

	}
}
?>