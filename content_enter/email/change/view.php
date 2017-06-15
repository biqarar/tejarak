<?php
namespace content_enter\email\change;

class view extends \content_enter\main\view
{
	public function config()
	{
		parent::config();

		$this->data->get_email = $this->login('email');
	}

}
?>