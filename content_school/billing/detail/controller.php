<?php
namespace content_school\billing\detail;

class controller extends  \content_school\main\controller
{

	public function _route()
	{
		parent::_route();

		$this->get("detail", "detail")->ALL("/^billing\/detail$/");

		$this->post("detail")->ALL("/^billing\/detail$/");
	}
}
?>