<?php
namespace content_enter\username\change;

class view extends \content_enter\main\view
{
	public function config()
	{
		parent::config();

		$this->data->get_username = $this->login('username');
	}
}
?>