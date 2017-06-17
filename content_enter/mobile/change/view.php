<?php
namespace content_enter\pass\change;

class view extends \content_enter\pass\view
{

	public function config()
	{
		parent::config();

		$this->data->page['title']   = T_('change mobile number');
		$this->data->page['desc']    = $this->data->page['title'];
	}
}
?>