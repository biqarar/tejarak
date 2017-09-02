<?php
namespace content_s\billing;

class controller extends  \content_s\main\controller
{

	public function _route()
	{
		parent::_route();
		$this->get("billing", "billing")->ALL();
		$this->post("billing")->ALL();

		$url = \lib\router::get_url();
		if(preg_match("/^billing\/invoice\/\d+$/", $url))
		{
			\lib\router::set_controller('\\content_s\\billing\\invoice');
			return;
		}
	}
}
?>