<?php
namespace content_enter\delete;
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
	public function post_delete($_args)
	{
		if(utility::post('why'))
		{
			self::set_enter_session('why', utility::post('why'));

			// set session verify_from signup
			self::set_enter_session('verify_from', 'delete');
			// find send way to send code
			// and send code
			// set step pass is done
			self::set_step_session('delete', true);

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
}
?>