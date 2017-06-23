<?php
namespace content_a\plan;

class controller extends  \content_a\main\controller
{

	public function _route()
	{
		parent::_route();
		$this->get(false, "plan")->ALL("/^([a-zA-Z0-9]+)\/plan$/");
		$this->post("plan")->ALL("/^([a-zA-Z0-9]+)\/plan$/");
	}

}

?>