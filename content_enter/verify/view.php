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

		// the verify msg
		$myTitle = T_('Verify');
		$myDesc  = T_('Please verify your account');
		// swich verify from
		switch (self::get_enter_session('verify_from'))
		{
			// user from signup go to this page
			case 'signup':
				switch (self::get_enter_session('verification_code_way'))
				{
					case 'telegram':
						$myDesc = T_("Your verifycation code send to your telegram");
						break;

					case 'call':
						$myDesc = T_("We near call to you");
						break;

					case 'sms':
						$myDesc = T_("Your verifycation code send to mobile number by sms");
						break;

					default:
						$myDesc = T_("What happend?");
						break;
				}
				break;

			// user from delete go to this page
			case 'delete':
				switch (self::get_enter_session('verification_code_way'))
				{
					case 'telegram':
						$myDesc = T_("Your verifycation code send to your telegram, you try to delete account");
						break;

					case 'call':
						$myDesc = T_("We near call to you, you try to delete account");
						break;

					case 'sms':
						$myDesc = T_("Your verifycation code send to mobile number by sms, you try to delete account");
						break;

					default:
						$myDesc = T_("What happend?, dont delete account");
						break;
				}
				break;

			// user from recovery go to this page
			case 'recovery':
				switch (self::get_enter_session('verification_code_way'))
				{
					case 'telegram':
						$myDesc = T_("Your verifycation code send to your telegram, you try to recovery your password");
						break;

					case 'call':
						$myDesc = T_("We near call to you, you try to recovery your password");
						break;

					case 'sms':
						$myDesc = T_("Your verifycation code send to mobile number by sms, you try to recovery your password");
						break;

					default:
						$myDesc = T_("What happend?, dont recovery your password");
						break;
				}
				break;

			// user from change password go to this page
			case 'change':
				// swich way
				switch (self::get_enter_session('verification_code_way'))
				{
					case 'telegram':
						$myDesc = T_("Your verifycation code send to your telegram, you try to change your password");
						break;

					case 'call':
						$myDesc = T_("We near call to you, you try to change your password");
						break;

					case 'sms':
						$myDesc = T_("Your verifycation code send to mobile number by sms, you try to change your password");
						break;

					default:
						$myDesc = T_("What happend?, dont change your password");
						break;
				}
				break;
		}

		$this->data->verify_msg = $myDesc;


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