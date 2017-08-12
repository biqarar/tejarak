<?php
namespace content_enter\verify\sendsms;
use \lib\utility;
use \lib\debug;
use \lib\db;
use \lib\sendsms\tg as bot;


class model extends \content_enter\main\model
{

	/**
	 * send verification code to the user sendsms
	 *
	 * @param      <type>  $_chat_id  The chat identifier
	 * @param      <type>  $_text     The text
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function send_sendsms_code()
	{

		if(self::user_data('id'))
		{
			$user_id = self::user_data('id');
		}
		else
		{
			return false;
		}

		$code = rand(10000,99999);

		self::set_enter_session('sendsms_code', $code);

		$log_id = \lib\db\logs::set('enter:get:sms:from:user', $user_id, ['data' => $code, 'meta' => ['session' => $_SESSION]]);

		self::set_enter_session('sendsms_code_log_id', $log_id);

		return true;
	}


	/**
	* check sended code
	*/
	public function post_verify()
	{
		$log_meta =
		[
			'meta' =>
			[
				'session' => $_SESSION,
				'post'    => utility::post(),
			]
		];

		$code = utility::post('code');
		if($code == self::get_enter_session('sendsms_code'))
		{
			$log_id = self::get_enter_session('sendsms_code_log_id');

			if($log_id)
			{
				$get_log_detail = \lib\db\logs::get(['id' => $log_id, 'limit' => 1]);
				if(!$get_log_detail || !isset($get_log_detail['log_status']))
				{
					\lib\db\logs::set('enter:verify:sendsmsm:log:not:found', self::user_data('id'), $log_meta);
					debug::error(T_("System error, try again"));
					return false;
				}

				switch ($get_log_detail['log_status'])
				{
					case 'deliver':
						// the user must be login
						\lib\db\logs::update(['log_status' => 'expire'], $log_id);
						// set login session
						$redirect_url = self::enter_set_login();

						// save redirect url in session to get from okay page
						self::set_enter_session('redirect_url', $redirect_url);
						// set okay as next step
						self::next_step('okay');
						// go to okay page
						self::go_to('okay');
						return;
						break;

					case 'enable':
						// user not send sms or not deliver to us
						\lib\db\logs::set('enter:verify:sendsmsm:sms:not:deliver:to:us', self::user_data('id'), $log_meta);
						debug::error(T_("Your sms not deliver to us!"));
						return false;
						break;

					case 'expire':
						// the user user from this way and can not use this way again
						// this is a bug!
						\lib\db\logs::set('enter:verify:sendsmsm:sms:expire:log:bug', self::user_data('id'), $log_meta);
						debug::error(T_("What are you doing?"));
						return false;
					default:
						// bug!
						return false;
						break;
				}
			}
			else
			{
				\lib\db\logs::set('enter:verify:sendsmsm:log:id:not:found', self::user_data('id'), $log_meta);
				debug::error(T_("What are you doing?"));
				return false;
			}
		}
		else
		{
			\lib\db\logs::set('enter:verify:sendsmsm:user:inspected:change:html', self::user_data('id'), $log_meta);
			debug::error(T_("What are you doing?"));
			return false;
		}
	}
}
?>
