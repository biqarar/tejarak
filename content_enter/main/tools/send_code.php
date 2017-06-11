<?php
namespace content_enter\main\tools;
use \lib\utility;
use \lib\debug;

trait send_code
{
	public static function send_way()
	{
		return 'telegram';
	}

	/**
	 * generate verification code
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function send_code()
	{
		$way = self::send_way();
		switch ($way)
		{
			case 'telegram':
			case 'sms1':
			case 'sms2':
			case 'call':
			case 'email':
				self::set_enter_session('send_way', $way);
				self::go_to('verify/'. $way);
				break;

			default:
				self::go_to('verify/what');
				break;
		}
	}

}
?>