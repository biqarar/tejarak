<?php
namespace content_school\billing\invoice;

class controller extends  \content_school\main\controller
{

	public function _route()
	{
		parent::_route();

		$this->get("invoice", "invoice")->ALL("/^billing\/invoice\/(\d+)$/");

		$this->post("invoice")->ALL("/^billing\/invoice\/(\d+)$/");
	}
}
?>