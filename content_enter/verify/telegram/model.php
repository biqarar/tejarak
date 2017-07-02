<?php
namespace content_enter\verify\telegram;
use \lib\utility;
use \lib\debug;
use \lib\db;
use \lib\telegram\tg as bot;


class model extends \content_enter\main\model
{

	/**
	 * send verification code to the user telegram
	 *
	 * @param      <type>  $_chat_id  The chat identifier
	 * @param      <type>  $_text     The text
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function send_telegram_code()
	{
		// the telegram is off for this project
		if(!\lib\option::social('telegram', 'status'))
		{
			return false;
		}
		// check the user have chat id or no
		if(!self::user_data('user_chat_id'))
		{
			return false;
		}

		$code = self::get_enter_session('verification_code');
		// make text
		$text = '';
		$text .= T_("Your login code is :code", ['code' => \lib\utility\human::number($code)]);
		$text .= "\n\n". T_("This code can be used to log in to your account. Do not give it to anyone!");
		$text .= "\n" . T_("If you didn't request this code, ignore this message.");

		// ready to send telegram message
		$msg =
		[
			'method'       => 'sendMessage',
			'text'         => $text,
			'chat_id'      => self::user_data('user_chat_id'),
		];

		\lib\utility\telegram::sendMessage(self::user_data('user_chat_id'), $text);

		return true;
		// // send telegram msg
		// $result = bot::sendResponse($msg);
		// // ready to save log
		// $log_meta =
		// [
		// 	'data' => $code,
		// 	'meta' =>
		// 	[
		// 		'telegram_result' => $result,
		// 		'text'            => str_replace("\n", ' ', $text),
		// 		'code'            => $code,
		// 		'session'         => $_SESSION,
		// 	]
		// ];

		// // save log
		// \lib\db\logs::set('enter:send:telegram:resutl', self::user_data('id'), $log_meta);
		// // if result is ok return true
		// if(isset($result['ok']) && $result['ok'] === true)
		// {

		// 	return true;
		// }
		// // can not send by telegram
		// return false;
	}


	/**
	* check sended code
	*/
	public function post_verify()
	{
		self::check_code('telegram');
	}
}
?>
