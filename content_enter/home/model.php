<?php
namespace content_enter\home;
use \lib\utility;
use \lib\debug;
use \lib\db;

class model extends \content_enter\main\model
{

	/**
	 * Posts an enter.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_enter($_args)
	{
		// get saved mobile in session to find count of change mobile
		$old_mobile = self::get_enter_session('mobile');

		// clean existing session
		self::clean_session();

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
			// plus count invalid mobile
			self::plus_try_session('invalid_mobile');
			// make error
			debug::error(T_("Invalid Mobile"), 'mobile', 'arguments');
			return false;
		}

		// if old mobile is different by new mobile
		// save in session this user change the mobile
		if($old_mobile && self::$mobile != $old_mobile)
		{
			self::plus_try_session('diffrent_mobile');
		}

		// set posted mobile in SESSION
		self::set_enter_session('mobile', self::$mobile);

		// load user data by mobile
		$user_data = self::user_data();

		// set this step is done
		self::set_step_session('mobile', true);

		// the user not found must be signup
		if(!$user_data)
		{
			// signup new user
			self::signup();

			// lock all step and set just this page to load
			self::next_step('pass/signup');

			// got to pass/signupt to get password from user
			self::go_to('pass/signup');
		}
		else
		{
			// if this user is blocked or filtered go to block page
			if(in_array(self::user_data('user_status'), self::$block_status))
			{
				// block page
				self::next_step('block');
				// go to block page
				self::go_to('block');
				return;
			}

			// the user_pass field is empty
			if(!self::user_data('user_pass'))
			{
				// lock all step and set just this page to load
				self::next_step('pass/set');

				// go to pass/set to get password from user
				self::go_to('pass/set');
			}
			else
			{
				// lock all step and set just this page to load
				self::next_step('pass');
				// open lock pass/recovery
				self::open_lock('pass/recovery');
				// go to pass to check password
				self::go_to('pass');
			}
		}
	}
}
?>