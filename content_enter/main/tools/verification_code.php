<?php
namespace content_enter\main\tools;
use \lib\utility;
use \lib\debug;

trait verification_code
{

	/**
	 * generate verification code
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function create_new_code($_way = null)
	{
		$code =  rand(10000,99999);
		if(self::$dev_mode)
		{
			$code = 11111;
		}
		// set verification code in session
		self::set_enter_session('verification_code', $code);
		$time = date("Y-m-d H:i:s");

		$log_meta =
		[
			'data'     => $code,
			'log_desc' => $_way,
			'time'     => $time,
			'meta'     =>
			[
				'session' => $_SESSION,
			],
		];

		// if the user id is set in session
		if(self::user_data('id'))
		{
			// save this code in logs table for this user
			$log_id = \lib\db\logs::set('user:verification:code', self::user_data('id'), $log_meta);
			// update users user_verifycode field
			// the user_verifycode like this
			// // 						 [CODE]	 _	[TIME]   _  [WAY]   _    [ID]
			// $user_verifycode_field = $code. "_". $time. "_". $way. "_". $log_id;
			// // update user field
			// \lib\db\users::update(['user_verifycode'], self::user_data('id'));
			// save data in session
			self::set_enter_session('verification_code', $code);
			self::set_enter_session('verification_code_time', $time);
			self::set_enter_session('verification_code_way', $_way);
			self::set_enter_session('verification_code_id', $log_id);
		}

		return $code;
	}


	/**
	 * check code exist and live
	 */
	public static function generate_verification_code()
	{
		// check last code time and if is not okay make new code
		$last_code_ok = false;
		// get saved session last verification code

		if
		(
			self::get_enter_session('verification_code') &&
			self::get_enter_session('verification_code_id') &&
			self::get_enter_session('verification_code_time')
		)
		{
			if(time() - strtotime(self::get_enter_session('verification_code_time')) < self::$life_time_code)
			{
				// last code is true
				// need less to create new code
				$last_code_ok = true;
			}
		}
		// // code not found in session
		// // load user data to find code
		// if(!$last_code_ok)
		// {
		// 	// get last verification code in users detail
		// 	$verification = self::user_data('user_verifiycode');
		// 	if($verification)
		// 	{
		// 		// the user_verifycode like this [[CODE]_[TIME]_[WAY]_[ID]]
		// 		// the user_verifycode like this [12345_2017-12-12 14:08:25_telegram_45]
		// 		$explode = explode('_', $verification);
		// 		if(isset($explode[1]))
		// 		{
		// 			if(strtotime($explode[1]) < self::$life_time_code)
		// 			{
		// 				// last save users code is okay
		// 				$last_code_ok = true;
		// 				// save last code in session
		// 				if(isset($explode[0]) && is_numeric($explode[0]))
		// 				{
		// 					self::set_enter_session('verification_code', $explode[0]);
		// 				}
		// 				// save last code time in session
		// 				if(isset($explode[1]))
		// 				{
		// 					self::set_enter_session('verification_code_time', $explode[1]);
		// 				}
		// 				// save last code way in session
		// 				if(isset($explode[2]))
		// 				{
		// 					self::set_enter_session('verification_code_way', $explode[2]);
		// 				}
		// 				// sve last code id in session
		// 				if(isset($explode[3]))
		// 				{
		// 					self::set_enter_session('verification_code_id', $explode[3]);
		// 				}
		// 			}
		// 		}
		// 	}
		// }

		// user code not found
		if(!$last_code_ok)
		{
			if(self::user_data('id'))
			{
				$where =
				[
					'caller'     => 'user:verification:code',
					'user_id'    => self::user_data('id'),
					'log_status' => 'enable',
					'limit'      => 1,
				];
				$log_code = \lib\db\logs::get($where);

				if($log_code)
				{
					if(isset($log_code['log_createdate']) && time() - strtotime($log_code['log_createdate']) < self::$life_time_code)
					{
						// the last code is okay
						// need less to create new code
						$last_code_ok = true;
						// save data in session
						if(isset($log_code['log_data']))
						{
							self::set_enter_session('verification_code', $log_code['log_data']);
						}
						// save log time
						if(isset($log_code['log_createdate']))
						{
							self::set_enter_session('verification_code_time', $log_code['log_createdate']);
						}
						// save log way
						if(isset($log_code['log_desc']))
						{
							self::set_enter_session('verification_code_way', $log_code['log_desc']);
						}
						// save log id
						if(isset($log_code['id']))
						{
							self::set_enter_session('verification_code_id', $log_code['id']);
						}

					}
					else
					{
						// the log is exist and the time of log is die
						// we expire the log
						if(isset($log_code['id']))
						{
							\lib\db\logs::update(['log_status' => 'expire'], $log_code['id']);
						}
					}
				}
			}
		}
		// if last code is not okay
		// make new code
		if(!$last_code_ok)
		{
			self::create_new_code();
		}
	}



	public static function check_code($_module)
	{
		if(!self::check_input_current_mobile())
		{
			debug::error(T_("Dont!"));
			return false;
		}

		if(!utility::post('code'))
		{
			debug::error(T_("Please fill the verification code"), 'code');
			return false;
		}

		if(!is_numeric(utility::post('code')))
		{
			debug::error(T_("What happend? the code is number. you try to send string!?"), 'code');
			return false;
		}

		if(intval(utility::post('code')) === intval(self::get_enter_session('verification_code')))
		{
			if(
				(
					self::get_enter_session('verify_from') === 'signup' ||
					self::get_enter_session('verify_from') === 'set' ||
					self::get_enter_session('verify_from') === 'recovery'
				) &&
				self::get_enter_session('temp_ramz_hash') &&
				is_numeric(self::user_data('id'))
			  )
			{
				// set temp ramz in use pass
				\lib\db\users::update(['user_pass' => self::get_enter_session('temp_ramz_hash')], self::user_data('id'));
			}

			if(self::get_enter_session('verify_from') === 'delete')
			{
				if(self::get_enter_session('why'))
				{
					$update_meta  = [];

					$user_meta = self::user_data('user_meta');
					if(!$user_meta)
					{
						$update_meta['why'] = self::get_enter_session('why');
					}
					elseif(is_string($user_meta) && substr($user_meta, 0, 1) !== '{')
					{
						$update_meta['other'] = $user_meta;
						$update_meta['why'] = self::get_enter_session('why');
					}
					elseif(is_string($user_meta) && substr($user_meta, 0, 1) === '{')
					{
						$json = json_decode($user_meta, true);
						$update_meta = array_merge($json, ['why' => self::get_enter_session('why')]);
					}

				}

				$update_user = [];
				if(!empty($update_meta))
				{
					$update_user['user_meta'] = json_encode($update_meta, JSON_UNESCAPED_UNICODE);
				}
				$update_user['user_status'] = 'removed';

				\lib\db\users::update($update_user, self::user_data('id'));

				\lib\db\sessions::delete_account(self::user_data('id'));

				//put logout
				self::set_logout(self::user_data('id'));

				self::go_to('byebye');
			}

			// set login session
			$redirect_url = self::enter_set_login();

			// save redirect url in session to get from okay page
			self::set_enter_session('redirect_url', $redirect_url);

			// go to okay page
			self::go_to('okay');

		}
		else
		{
			// wrong code sleep code
			self::sleep_code();

			// plus count invalid code
			self::plus_try_session('invalid_code_call');

			debug::error(T_("Invalid code, try again"), 'code');
			return false;
		}
	}


	/**
	 * Sends a code email.
	 * send verification code whit email address
	 */
	public static function send_code_email()
	{
		$email = self::get_enter_session('temp_email');
		$code  = self::generate_verification_code();
		$mail =
		[
			'from'    => 'info@sarshomar.com',
			'to'      => $email,
			'subject' => 'contact',
			'body'    => "salam". $code,
			'debug'   => true,
		];
		$mail = \lib\utility\mail::send($mail);
		return $mail;
	}
}
?>