<?php
namespace content\contact;

class controller extends \content\main\controller
{
	function _route()
	{
		parent::_route();

		$this->get(false, false)->ALL("/contact/");
		$this->post("contact")->ALL("/contact/");
		// $this->get()
	}
}
?>