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
	public static function make_new_code()
	{
		$code =  rand(10000,99999);
		if(self::$dev_mode)
		{
			$code = 11111;
		}
		// set verification code in session
		self::set_enter_session('verification_code', $code);
		return $code;
	}


	/**
	 * check code exist and live
	 */
	public static function generate_verification_code()
	{
		if(self::last_code() && self::last_code_life() < self::$life_time_code)
		{
			// needless to create new code
		}
		else
		{
			$code = self::make_new_code();
		}
	}


	/**
	 * Loads an exist verification code.
	 */
	public static function exist_code()
	{
		// get saved session last verification code
		if(!self::get_enter_session('verification_code'))
		{
			// get last verification code in users detail
			$verification = self::user_data('user_verifiycode');
			if($verification)
			{
				$explode = explode('_', $verification);
				if(isset($explode[0]) && is_numeric($explode[0]))
				{
					self::set_enter_session('verification_code', $explode[0]);
				}

				if(isset($explode[1]))
				{
					self::set_enter_session('verification_code_time', $explode[1]);
				}

				if(isset($explode[2]))
				{
					self::set_enter_session('verification_code_way', $explode[2]);
				}
			}
		}
	}


	/**
	 * Gets the last sended code.
	 *
	 * @return     <type>  The last sended code.
	 */
	public static function last_code()
	{
		self::exist_code();
		return self::get_enter_session('verification_code');
	}


	/**
	 * get last way sended code
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function last_way()
	{
		self::exist_code();
		return self::get_enter_session('verification_code');
	}


	/**
	 * get verification code life
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function last_code_life()
	{
		self::exist_code();
		$time = self::get_enter_session('verification_code_time');
		return strtotime($time);
	}

}
?>