<?php
namespace content_enter\okay;


class view extends \content_enter\main\view
{
	public function config()
	{
		// read parent config to fill the mobile input and other thing
		parent::config();

		if(self::get_enter_session('redirect_url'))
		{
			$this->data->redirect_url = self::get_enter_session('redirect_url');
		}
	}
}
?>