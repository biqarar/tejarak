<?php
namespace content_enter\home;
use \lib\utility;
use \lib\debug;
use \lib\db;

class model extends \content_enter\main\model
{
	/**
	 * Gets the enter.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_enter($_args)
	{

	}


	/**
	 * Posts an enter.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_enter($_args)
	{
		// check inup is ok
		if(!self::check_input('mobile'))
		{
			debug::error(T_("Dont!"));
			return false;
		}

		// check syntax of mobile is true
		if($mobile = utility\filter::mobile(utility::post('mobile')))
		{
			self::$mobile = $mobile;
		}
		else
		{
			debug::error(T_("Invalid Mobile"), 'mobile', 'arguments');
			// redirect to error page
			// self::go_to('error');
			return false;
		}

		// set posted mobile in SESSION
		self::set_enter_session('mobile', self::$mobile);

		// load user data by mobile
		$user_data = self::user_data();
		// the user not found must be signup
		if(!$user_data)
		{
			// signup new user
			self::signup();
			// got to pass/signupt to get password from user
			self::go_to('pass/signup');
		}
		else
		{
			// the user_pass field is empty
			if(!self::user_data('user_pass'))
			{
				// go to pass/signup to get password from user
				self::go_to('pass/signup');
			}
			else
			{
				// go to pass to check password
				self::go_to('pass');
			}
		}
	}
}
?>