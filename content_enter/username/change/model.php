<?php
namespace content_enter\username\change;
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
	public function post_username($_args)
	{
		// check inup is ok
		if(!self::check_input('username/change'))
		{
			debug::error(T_("Dont!"));
			return false;
		}

		// check ramz fill
		if(!utility::post('ramz'))
		{
			debug::error(T_("Please fill the usernameword field"));
			return false;
		}

		// check ramz fill
		if(!utility::post('ramzNew'))
		{
			debug::error(T_("Please fill the new usernameword field"));
			return false;
		}

		// check old username == new username?
		if(utility::post('ramz') == utility::post('ramzNew'))
		{
			debug::error(T_("Please set a different usernameword!"));
			return false;
		}

		// check min and max usernameword
		if(!$this->check_username_syntax(utility::post('ramz')))
		{
			return false;
		}

		// check min and max usernameword
		if(!$this->check_username_syntax(utility::post('ramzNew')))
		{
			return false;
		}

		// check old usernameword is okay
		if(!\lib\utility::hasher(utility::post('ramz'), $this->login('username')))
		{
			self::plus_try_session('change_usernameword_invalid_old');
			debug::error(T_("Invalid old usernameword"));
			return false;
		}

		// hesh ramz to find is this ramz is easy or no
		// creazy usernameword !
		$temp_ramz_hash = \lib\utility::hasher(utility::post('ramzNew'));
		// if debug status continue
		if(debug::$status)
		{
			self::set_enter_session('temp_ramz', utility::post('ramzNew'));
			self::set_enter_session('temp_ramz_hash', $temp_ramz_hash);
		}
		else
		{
			// creazy usernameword
			return false;
		}

		// set session verify_from change
		self::set_enter_session('verify_from', 'change');
		// find send way to send code
		// and send code

		// send code way
		self::send_code_way();
	}
}
?>