<?php
namespace content_s\billing\detail;

class controller extends  \content_s\main\controller
{

	public function _route()
	{
		parent::_route();

		$this->get("detail", "detail")->ALL("/^billing\/detail$/");

		$this->post("detail")->ALL("/^billing\/detail$/");
	}
}
?>