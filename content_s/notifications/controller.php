<?php
namespace content_s\notifications;

class controller extends  \content_s\main\controller
{

	public function _route()
	{
		parent::_route();
		$this->get("notifications", "notifications")->ALL();
		$this->post("notifications")->ALL();
	}
}
?>