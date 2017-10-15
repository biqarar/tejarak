<?php
namespace content_a\notifications;

class controller extends  \content_a\main\controller
{

	public function ready()
	{

		$this->get("notifications", "notifications")->ALL();
		$this->post("notifications")->ALL();
	}
}
?>