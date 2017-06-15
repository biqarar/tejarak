<?php
namespace content_enter\username\set;
use \lib\utility;
use \lib\debug;
use \lib\db;

class model extends \content_enter\username\model
{
	/**
	 * Gets the enter.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_username($_args)
	{

	}


	/**
	 * Posts an enter.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_username($_args)
	{
		// check inup is ok
		if(!self::check_input('username/set'))
		{
			debug::error(T_("Dont!"));
			return false;
		}

		if(utility::post('ramz'))
		{
			$temp_ramz = utility::post('ramz');

			// check min and max of usernameword and make error
			if(!$this->check_username_syntax($temp_ramz))
			{
				return false;
			}

			// hesh ramz to find is this ramz is easy or no
			// creazy usernameword !
			$temp_ramz_hash = \lib\utility::hasher($temp_ramz);
			// if debug status continue
			if(debug::$status)
			{
				self::set_enter_session('temp_ramz', $temp_ramz);
				self::set_enter_session('temp_ramz_hash', $temp_ramz_hash);
			}
			else
			{
				// creazy usernameword
				return false;
			}
		}
		else
		{
			// plus count invalid usernameword
			self::plus_try_session('no_usernameword_send_set');

			debug::error(T_("No usernameword was send"));
			return false;
		}

		// set session verify_from set
		self::set_enter_session('verify_from', 'set');
		// find send way to send code
		// and send code
		// set step username is done
		self::set_step_session('username', true);

		// send code way
		self::send_code_way();
	}
}
?>