<?php
namespace content_school\billing;

class controller extends  \content_school\main\controller
{

	public function _route()
	{
		parent::_route();
		$this->get("billing", "billing")->ALL();
		$this->post("billing")->ALL();

		$url = \lib\router::get_url();
		if(preg_match("/^billing\/invoice\/\d+$/", $url))
		{
			\lib\router::set_controller('\\content_school\\billing\\invoice');
			return;
		}
	}
}
?>