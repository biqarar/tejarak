<?php
namespace content_enter\pass\signup;
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
	public function get_pass($_args)
	{

	}


	/**
	 * Posts an enter.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_pass($_args)
	{
		// check inup is ok
		if(!self::check_input('pass/signup'))
		{
			debug::error(T_("Dont!"));
			return false;
		}

		if(utility::post('ramz'))
		{
			$temp_ramz = utility::post('ramz');

			// cehck min leng of password is 6 character
			if(mb_strlen($temp_ramz) < 6)
			{
				debug::error(T_("You must set 6 character and large in password"));
				return false;
			}
			// cehck max length of password
			if(mb_strlen($temp_ramz) > 100)
			{
				debug::error(T_("You must set less than 100 character in password"));
				return false;
			}
			// hesh ramz to find is this ramz is easy or no
			// creazy password !
			$temp_ramz_hash = \lib\utility::hasher($temp_ramz);
			// if debug status continue
			if(debug::$status)
			{
				self::set_enter_session('temp_ramz', $temp_ramz);
				self::set_enter_session('temp_ramz_hash', $temp_ramz_hash);
			}
			else
			{
				// creazy password
				return false;
			}
		}
		else
		{
			// plus count invalid password
			self::plus_try_session('no_password_send_signup');

			debug::error(T_("No password was send"));
			return false;
		}

		// set session verify_from signup
		self::set_enter_session('verify_from', 'signup');
		// find send way to send code
		// and send code
		// set step pass is done
		self::set_step_session('pass', true);

		// find send way to send code
		$way = self::send_way();
		if(!$way)
		{
			// no way to send code
			self::go_to('verify/what');
		}
		else
		{
			// go to verify page
			self::go_to('verify/'. $way);
		}
	}
}
?>