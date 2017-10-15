<?php
namespace content\contact;

class controller extends \content\main\controller
{
	function ready()
	{
		$this->post("contact")->ALL("/contact/");
	}
}
?>