<?php
namespace content_enter\main;


class model extends \mvc\model
{
	use \content_enter\main\tools\check_input;
	use \content_enter\main\tools\user_data;
	use \content_enter\main\tools\go_to;
	use \content_enter\main\tools\SESSION;
	use \content_enter\main\tools\verification_code;
	use \content_enter\main\tools\send_code;
	use \content_enter\main\tools\done_step;
	use \content_enter\main\tools\error;
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
	// public static $block_type     = 'ip';
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

	/**
	 * send code rate
	 * you can custumise in very project in option.php -> self::$enter['send_rate']
	 *
	 * @var        array
	 */
	public static $send_rate =
	[
		'telegram',
		'sms1',
		'call',
		'sms2',
	];


	/**
	 * resend code rating
	 * you can custumise in very project in option.php -> self::$enter['resend_rate']
	 *
	 * @var        array
	 */
	public static $resend_rate =
	[
		'telegram',
		'sms1',
		'call',
		'sms2',
	];



	/**
	 * load some data from options
	 */
	public function _construct()
	{
		// get the enter way sorting from options
		if(\lib\option::enter('send_rate') && is_array(\lib\option::enter('send_rate')))
		{
			self::$send_rate = \lib\option::enter('send_rate');
		}

		// get resend rate code from lib option
		if(\lib\option::enter('resend_rate') && is_array(\lib\option::enter('resend_rate')))
		{
			self::$resend_rate = \lib\option::enter('resend_rate');
		}

		// load parent::_construct if exist
		if(method_exists('parent', '_construct'))
		{
			parent::_construct();
		}
	}

}
?>