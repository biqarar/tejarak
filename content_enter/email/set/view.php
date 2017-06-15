<?php
namespace content_enter\email\set;

class view extends \content_enter\main\view
{

	public function config()
	{
		parent::config();

		$this->data->get_email = $this->login('email');
	}

}
?>