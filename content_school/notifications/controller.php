<?php
namespace content_school\notifications;

class controller extends  \content_school\main\controller
{

	public function _route()
	{
		parent::_route();
		$this->get("notifications", "notifications")->ALL();
		$this->post("notifications")->ALL();
	}
}
?>