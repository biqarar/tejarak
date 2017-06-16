<?php
namespace content_enter\google;


class view extends \content_enter\main\view
{
	public function config()
	{
		parent::config();

		$this->data->auth_url = \lib\social\google::auth_url();
	}
}
?>