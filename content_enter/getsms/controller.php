<?php
namespace content_enter\getsms;

class controller extends \content_enter\main\controller
{
	public function _route()
	{
		$this->get("getsms")->ALL();
		$this->post("getsms")->ALL();

	}
}
?>