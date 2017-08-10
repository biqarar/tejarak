<?php
namespace content_enter\verify;


class view extends \content_enter\main\view
{
	/**
	 * config
	 */
	public function config()
	{
		parent::config();

		// change inpu
		if(self::done_step('username'))
		{
			// if user go to this page from username page
			$this->data->mobile_username = 'eusername';
		}
		else
		{
			// if user go to this page from mobile page
			$this->data->mobile_username = 'emobile';
		}
		// load temp username in username field
		if(self::get_session('username', 'temp_username'))
		{
			$this->data->get_username = self::get_session('username', 'temp_username');
		}

		// the verify msg
		$myDesc  = T_('Please verify yourself.'). ' ';
		// swich verify from
		switch (self::get_enter_session('verify_from'))
		{
			// user from signup go to this page
			case 'signup':
			case 'set':
				switch (self::get_enter_session('verification_code_way'))
				{
					case 'telegram':
						$myDesc .= T_("Your verification code send to your telegram.");
						break;

					case 'call':
						$myDesc .= T_("We try to call to you. be patient...");
						break;

					case 'sms':
						$myDesc .= T_("Your verification code send to you mobile via sms.");
						break;

					default:
						$myDesc .= T_("What happend?");
						break;
				}
				break;

			// user from delete go to this page
			case 'delete':
				switch (self::get_enter_session('verification_code_way'))
				{
					case 'telegram':
						$myDesc = T_("Your verification code send to your telegram, you try to delete account.");
						break;

					case 'call':
						$myDesc = T_("We try to call to you, you try to delete account.");
						break;

					case 'sms':
						$myDesc = T_("Your verification code send to mobile number by sms, you try to delete account.");
						break;

					default:
						$myDesc = T_("What happend?, dont delete account.");
						break;
				}
				break;

			// user from recovery go to this page
			case 'recovery':
				switch (self::get_enter_session('verification_code_way'))
				{
					case 'telegram':
						$myDesc = T_("Your verification code send to your telegram, you try to recovery your password.");
						break;

					case 'call':
						$myDesc = T_("We try to call to you, you try to recovery your password.");
						break;

					case 'sms':
						$myDesc = T_("Your verification code send to mobile number by sms, you try to recovery your password.");
						break;

					default:
						$myDesc = T_("What happend?, dont recovery your password.");
						break;
				}
				break;

			// user from change password go to this page
			case 'change':
				// swich way
				switch (self::get_enter_session('verification_code_way'))
				{
					case 'telegram':
						$myDesc = T_("Your verification code send to your telegram, you try to change your password.");
						break;

					case 'call':
						$myDesc = T_("We try to call to you, you try to change your password.");
						break;

					case 'sms':
						$myDesc = T_("Your verification code send to mobile number by sms, you try to change your password.");
						break;

					default:
						$myDesc = T_("What happend?, dont change your password.");
						break;
				}
				break;
		}

		$myDesc                 = trim($myDesc);
		$this->data->verify_msg = $myDesc;
		$myTitle                = T_('Verify');
		// set title of pages
		switch (\lib\router::get_url(1))
		{
			case 'call':
				$myTitle = T_('Verify by Call');
				break;

			case 'telegram':
				$myTitle = T_('Verify via Telegram');
				break;

			case 'sms':
				$myTitle = T_('verify with SMS');
				break;
		}

		$this->data->page['title'] = $myTitle;
		$this->data->page['desc']  = $myDesc;
	}
}
?>