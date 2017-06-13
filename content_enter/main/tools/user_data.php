<?php
namespace content_enter\main\tools;
use \lib\utility;
use \lib\debug;

trait user_data
{

	/**
	 * Loads an user data.
	 */
	private static function load_user_data()
	{
		if(self::$mobile)
		{
			$data = \lib\db\users::get_by_mobile(self::$mobile);
			if($data)
			{
				$_SESSION['enter']['user_data'] = $data;
			}
		}
	}

	/**
	 * { function_description }
	 *
	 * @param      <type>  $_key   The key
	 */
	public static function user_data($_key = null)
	{
		if(!isset($_SESSION['enter']['user_data']))
		{
			self::load_user_data();
		}

		if($_key)
		{
			if(isset($_SESSION['enter']['user_data'][$_key]))
			{
				return $_SESSION['enter']['user_data'][$_key];
			}
			return null;
		}

		if(isset($_SESSION['enter']['user_data']))
		{
			return $_SESSION['enter']['user_data'];
		}
		return null;
	}


	/**
	*	Signup new user
	*/
	public static function signup()
	{
		$mobile = self::get_enter_session('mobile');
		if($mobile)
		{
			$args =
			[
				'mobile' => $mobile,
				'displayname' => null,
				'password' => null,
				'status' => 'awaiting'
			];
			$user_id = \lib\db\users::signup($args);

			if($user_id)
			{
				self::set_enter_session('id', $user_id);
				self::set_enter_session('status', 'awaiting');
			}
		}
	}
}
?>