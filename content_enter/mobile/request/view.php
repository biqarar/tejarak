<?php
namespace content_enter\mobile\request;

class view extends \content_enter\main\view
{
	public function config()
	{
		parent::config();

		$this->data->page['title']   = T_('Request mobile number');
		$this->data->page['desc']    = $this->data->page['title'];
	}
}
?>