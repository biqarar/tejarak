<?php
namespace content_a\report;

class view extends \content_a\main\view
{
	public function config()
	{
		parent::config();

		$this->data->page['title'] = T_('Reports');
		$this->data->page['desc']  = $this->data->page['title'];
	}
}
?>