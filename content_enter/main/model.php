<?php
namespace content_enter\main;


class model extends \mvc\model
{
	/**
	 * dev mode
	 * make code as 11111
	 *
	 * @var        boolean
	 */
	public static $dev_mode          = false;


	public static $have_main_account = false;

	public static $mobile            = null;
	public static $username          = null;
	public static $pin               = null;
	public static $code              = null;
	public static $user_data         = [];
	public static $user_id           = null;
	public static $guest_user_id     = null;
	public static $signup            = false;
	public static $telegram_chat_id  = null;
	public static $telegram_detail   = [];
	// public static $block_type     = 'ip-agent';
	public static $block_type        = 'session';
	public static $is_guest          = false;

	// config to send to javaScript
	public static $wait              = 0;
	// show resende link ofter
	public static $resend_after      = 60 * 1; // 1 min
	// life time code to expire
	public static $life_time_code    = 60 * 5; // 5 min

	public static $sended_code       = [];
	public static $create_new_code   = false;
	public static $resend_rate =
	[
		'sms1',
		'call',
		'telegram',
		'sms2',
	];


	use \content_enter\main\tools\check_input;
	use \content_enter\main\tools\user_data;
	use \content_enter\main\tools\go_to;
	use \content_enter\main\tools\SESSION;
	use \content_enter\main\tools\verification_code;
	use \content_enter\main\tools\send_code;

}
?>