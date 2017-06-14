<?php
namespace content_enter\username;
use \lib\utility;
use \lib\debug;

class model extends \content_enter\main\model
{
	public function post_username()
	{
		if(!self::check_password_is_null())
		{
			debug::error(T_("Dont!"));
			return false;
		}
		// get user name
		$username = utility::post('username');
		// check user name is fill
		if(!$username)
		{
			debug::error(T_("Please fill the username field"), 'username');
			return false;
		}

		// get password [ramz]
		$ramz = utility::post('ramz');
		if(!$ramz)
		{
			debug::error(T_("Please fill the password field"));
			return false;
		}
		// set username
		self::$username = $username;
		// load userdata by username
		self::load_user_data('username');
		// check username exist
		if(!self::user_data() || !self::user_data('id'))
		{
			// plus count invalid username
			self::plus_try_session('invalid_username');

			debug::error(T_("Username not found"));
			return false;
		}

		$log_meta =
		[
			'meta' =>
			[
				'session'   => $_SESSION,
				'user_data' => self::user_data(),
			],
		];

		if(!self::user_data('user_pass'))
		{
			// BUG username set and password is not set
			\lib\db\logs::set('enter:username:set:password:notset', self::user_data('id'), $log_meta);
			debug::error(T_("Invalid password"));
			return false;
		}
		// check password
		if(\lib\utility::hasher($ramz, self::user_data('user_pass')))
		{
			// set login
			self::enter_set_login();
		}
		else
		{
			self::plus_try_session('invalid_password');

			debug::error(T_("Invalid password"));
			return false;
		}
	}
}
?>