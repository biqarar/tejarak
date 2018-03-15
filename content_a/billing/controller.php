<?php
namespace content_a\billing;

class controller extends  \content_a\main\controller
{

	public function ready()
	{

		$this->get("billing", "billing")->ALL();
		$this->post("billing")->ALL();

		$url = \lib\url::directory();
		if(preg_match("/^billing\/invoice\/\d+$/", $url))
		{
			\lib\router::set_controller('\\content_a\\billing\\invoice');
			return;
		}
	}
}
?>