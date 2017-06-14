<?php
namespace content_enter\pass;


class view extends \content_enter\main\view
{
	public function config()
	{
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
	}
}
?>