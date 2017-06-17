<?php
namespace content_enter\main\tools;
use \lib\utility;
use \lib\debug;

trait user_data
{

	/**
	 * Loads an user data.
	 */
	public static function load_user_data($_type = 'mobile')
	{
		$data = [];

		switch ($_type)
		{
			// get user data by mobile
			case 'mobile':
				if(self::$mobile)
				{
					$data = \lib\db\users::get_by_mobile(self::$mobile);
				}
				break;

			// get use data by username
			case 'username':
				if(self::$username)
				{
					$data = \lib\db\users::get_by_username(self::$username);
				}
				break;

			// get user data by user id
			case 'user_id':
				if(self::$user_id)
				{
					$data = \lib\db\users::get(self::$user_id);
				}
				break;

			// get use data by email
			case 'email':
				if(self::$email)
				{
					$data = \lib\db\users::get_by_email(self::$email, true);
				}
				break;

			default:
				# code...
				break;
		}

		if($data)
		{
			$_SESSION['enter']['user_data'] = $data;
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
	public static function signup($_args = [])
	{

		$default_args =
		[
			'mobile'      => null,
			'displayname' => null,
			'password'    => null,
			'email'       => null,
			'status'      => 'awaiting'
		];

		if(is_array($_args))
		{
			$_args = array_merge($default_args, $_args);
		}

		$mobile = self::get_enter_session('mobile');
		if($mobile)
		{
			$update_user = [];
			if(isset($_args['user_google_mail']))
			{
				$update_user['user_google_mail'] = $_args['user_google_mail'];
			}
			// set mobile to use in other function
			self::$mobile    = $mobile;
			$_args['mobile'] = $mobile;
			$_args['email']  = self::$email;

			$user_id = \lib\db\users::signup($_args);

			if($user_id)
			{
				if(!empty($update_user))
				{
					\lib\db\users::update($update_user, $user_id);
				}
				self::load_user_data();
			}
			return $user_id;
		}
	}
}
?>