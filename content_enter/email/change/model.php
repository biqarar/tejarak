<?php
namespace content_enter\email\change;
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
	public function post_change($_args)
	{
		if(!utility::post('emailNew'))
		{
			debug::error(T_("Plese fill the new email"));
			return false;
		}

		if(!utility::post('email'))
		{
			debug::error(T_("Plese fill the old email"));
			return false;
		}

		if(utility::post('email') == utility::post('emailNew'))
		{
			debug::error(T_("Please select a different email"));
			return false;
		}

		if(utility::post('emailNew'))
		{
			self::set_enter_session('temp_email', utility::post('emailNew'));
		}

		// set session verify_from set
		self::set_enter_session('verify_from', 'email_set');

		// send code whit email
		self::send_code_email();
	}
}
?>