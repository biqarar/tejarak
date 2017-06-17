<?php
namespace content_enter\byebye;


class view extends \content_enter\main\view
{
	public function config()
	{
		// read parent config to fill the mobile input and other thing
		parent::config();

		$this->data->page['title']   = T_('Come back to us!');
		$this->data->page['desc']    = $this->data->page['title'];
	}
}
?>