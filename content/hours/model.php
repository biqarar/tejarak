<?php
namespace content\hours;
use \lib\utility;
use \lib\debug;

class model extends \content\main\model
{

	/**
	 * Gets the list.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function list_member($_args)
	{
		$this->user_id     = $this->login('id');
		$request           = [];
		$request['team']   = isset($_args['team']) ? $_args['team'] : null;
		$request['branch'] = isset($_args['branch']) ? $_args['branch'] : null;
		utility::set_request_array($request);
		$result =  $this->get_list_member();
		return $result;
	}


	/**
	 * Posts hours.
	 * save enter and exit of users
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function post_hours()
	{
		if(!$this->login())
		{
			return false;
		}

		$user_id = false;

		// set user id
		$user_id = intval(utility::post('user'));

		$result        = null;
		//----------- get values from post
		$arg =
		[
			'user_id' => $user_id,
			'plus'    => intval(utility::post('plus')),
			'minus'   => intval(utility::post('minus'))
		];
		// // set name of user
		// $this->setName($arg['user_id']);

		$result = \lib\db\staff::set_time($arg);

		switch ($result)
		{
			case false:
				debug::error(T_("User not found"));
				break;

			case 'enter':
				$msg_notify = T_("Dear :name;", ['name'=> self::$user_name])."<br />". T_('Your enter was registered.').' '. T_("Have a good time.");
				debug::true($msg_notify);
				// send message from telegram
				// self::generate_telegram_text('enter', $arg);
				break;

			case 'exit':
				$msg_notify = T_("Bye Bye :name ;)", ['name'=> self::$user_name]);
				debug::warn($msg_notify);
				// self::generate_telegram_text('exit', $arg);
				break;

			default:
				debug::warn(':|');
				break;
		}
		// send class name for absent on present
		debug::msg('result', $result);
	}
}
?>