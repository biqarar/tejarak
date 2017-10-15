<?php
namespace content_a\billing\invoice;

class controller extends  \content_a\main\controller
{

	public function ready()
	{


		$this->get("invoice", "invoice")->ALL("/^billing\/invoice\/(\d+)$/");

		$this->post("invoice")->ALL("/^billing\/invoice\/(\d+)$/");
	}
}
?>