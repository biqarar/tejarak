<?php
namespace content_a\notifications;

class controller extends  \content_a\main\controller
{

	public function _route()
	{
		parent::_route();
		$this->get("notifications", "notifications")->ALL();
		$this->post("notifications")->ALL();
	}
}
?>