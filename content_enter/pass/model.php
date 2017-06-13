<?php
namespace content_enter\pass;
use \lib\utility;
use \lib\debug;
use \lib\db;

class model extends \content_enter\main\model
{
	public function post_check()
	{
		if(!utility::post('ramz'))
		{
			debug::error(T_("Please enter your password"));
			return false;
		}

		$ramz = utility::post('ramz');
		if(self::user_data('user_pass'))
		{
			// the password is okay
			if(\lib\utility::hasher($ramz, self::user_data('user_pass')))
			{
				// set login session
				self::enter_set_login();
			}
			else
			{
				// plus count invalid password
				self::plus_try_session('invalid_password');

				// wrong password sleep code
				self::sleep_code();

				debug::error(T_("Invalid password, try again"));
				return false;
			}
		}
		else
		{
			self::go_to('error');
		}
	}
}
?>