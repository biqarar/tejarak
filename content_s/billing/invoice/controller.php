<?php
namespace content_s\billing\invoice;

class controller extends  \content_s\main\controller
{

	public function _route()
	{
		parent::_route();

		$this->get("invoice", "invoice")->ALL("/^billing\/invoice\/(\d+)$/");

		$this->post("invoice")->ALL("/^billing\/invoice\/(\d+)$/");
	}
}
?>