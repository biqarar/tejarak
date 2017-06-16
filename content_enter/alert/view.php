<?php
namespace content_enter\alert;


class view extends \content_enter\main\view
{
	public function config()
	{
		// read parent config to fill the mobile input and other thing
		parent::config();

		$this->data->page['title']   = T_('Alert!');
		$this->data->page['special'] = true;
		$this->data->page['desc']    = $this->data->page['title'];

		$this->data->alert_msg = self::get_alert();
	}
}
?>