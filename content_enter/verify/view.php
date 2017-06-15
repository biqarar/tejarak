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
		$verify_msg = null;
		// swich verify from
		switch (self::get_enter_session('verify_from'))
		{
			// user from signup go to this page
			case 'signup':
				// swich way
				switch (self::get_enter_session('verification_code_way'))
				{
					// telegram
					case 'telegram':
						$verify_msg = T_("Your verifycation code send to your telegram");
						break;
					// call
					case 'call':
						$verify_msg = T_("We near call to you");
						break;
					// sms
					case 'sms':
						$verify_msg = T_("Your verifycation code send to mobile number by sms");
						break;

					default:
						$verify_msg = T_("What happend?");
						break;
				}
				break;

			// user from delete go to this page
			case 'delete':
				// swich way
				switch (self::get_enter_session('verification_code_way'))
				{
					// telegram
					case 'telegram':
						$verify_msg = T_("Your verifycation code send to your telegram, you try to delete account");
						break;
					// call
					case 'call':
						$verify_msg = T_("We near call to you, you try to delete account");
						break;
					// sms
					case 'sms':
						$verify_msg = T_("Your verifycation code send to mobile number by sms, you try to delete account");
						break;

					default:
						$verify_msg = T_("What happend?, dont delete account");
						break;
				}
				break;

			// user from recovery go to this page
			case 'recovery':
				// swich way
				switch (self::get_enter_session('verification_code_way'))
				{
					// telegram
					case 'telegram':
						$verify_msg = T_("Your verifycation code send to your telegram, you try to recovery your password");
						break;
					// call
					case 'call':
						$verify_msg = T_("We near call to you, you try to recovery your password");
						break;
					// sms
					case 'sms':
						$verify_msg = T_("Your verifycation code send to mobile number by sms, you try to recovery your password");
						break;

					default:
						$verify_msg = T_("What happend?, dont recovery your password");
						break;
				}
				break;

			// user from change password go to this page
			case 'change':
				// swich way
				switch (self::get_enter_session('verification_code_way'))
				{
					// telegram
					case 'telegram':
						$verify_msg = T_("Your verifycation code send to your telegram, you try to change your password");
						break;
					// call
					case 'call':
						$verify_msg = T_("We near call to you, you try to change your password");
						break;
					// sms
					case 'sms':
						$verify_msg = T_("Your verifycation code send to mobile number by sms, you try to change your password");
						break;

					default:
						$verify_msg = T_("What happend?, dont change your password");
						break;
				}
				break;
			default:

				$verify_msg = T_("What happend? where you here?");
				break;
		}

		$this->data->verify_msg = $verify_msg;
	}
}
?>