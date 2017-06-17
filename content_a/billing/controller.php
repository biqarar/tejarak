<?php
namespace content_a\billing;

class controller extends  \content_a\main\controller
{

	public function _route()
	{
		parent::_route();
		$this->get("billing", "billing")->ALL();
		$this->post("billing")->ALL();

		$this->get("verify")->ALL("/billing\/verify\/(zarinpal)/");
	}

}

?>