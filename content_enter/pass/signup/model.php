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
			self::set_enter_session('temp_ramz', utility::post('ramz'));
		}
		else
		{
			debug::error(T_("Invalid Password"));
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