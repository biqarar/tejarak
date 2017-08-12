<?php
namespace content_enter\verify\sendsms;


class view extends \content_enter\verify\view
{
	public function config()
	{
		parent::config();
		// $this->data->page['title'] = ;
		$this->data->page['desc']  = T_("Send SMS to login");
		if(self::get_enter_session('sendsms_code'))
		{
			$this->data->sendsms_code = self::get_enter_session('sendsms_code');
		}
	}
}
?>