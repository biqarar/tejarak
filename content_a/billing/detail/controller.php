<?php
namespace content_a\billing\detail;

class controller extends  \content_a\main\controller
{

	public function _route()
	{
		parent::_route();

		$this->get("detail", "detail")->ALL("/^billing\/detail$/");

		$this->post("detail")->ALL("/^billing\/detail$/");
	}
}
?>