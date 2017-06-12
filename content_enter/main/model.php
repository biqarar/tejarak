<?php
namespace content_enter\main;


class model extends \mvc\model
{

	use _use;

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

		// get sms rate
		if(\lib\option::enter('sms_rate') && is_array(\lib\option::enter('sms_rate')))
		{
			self::$sms_rate = \lib\option::enter('sms_rate');
		}

		// in dev mode
		if(Tld === 'dev')
		{
			self::$dev_mode = true;
		}
		// load parent::_construct if exist
		if(method_exists('parent', '_construct'))
		{
			parent::_construct();
		}
	}

}
?>