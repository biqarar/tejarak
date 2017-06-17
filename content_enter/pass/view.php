<?php
namespace content_enter\pass;


class view extends \content_enter\main\view
{
	public function config()
	{
		// read parent config to fill the mobile input and other thing
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

		$this->data->page['title'] = T_('Password');
		$this->data->page['desc']  = T_('Please enter password to login');

		switch (\lib\router::get_url(1))
		{
			case 'recovery':
				$this->data->page['title'] = T_('Recovery Password');
				$this->data->page['desc']  = T_('Please enter new password!');
				break;

			case 'signup':
				$this->data->page['title'] = T_('Set Password');
				$this->data->page['desc']  = T_('Please set your password to secure signup');
				break;

			case 'change':
				$this->data->page['title'] = T_('Change to new Password');
				$this->data->page['desc']  = T_('Please set your old and new password to change it');
				break;

			case 'set':
				$this->data->page['title'] = T_('Set Password');
				$this->data->page['desc']  = T_('Please set password to secure your account');
				break;

			default:
				break;
		}
	}
}
?>