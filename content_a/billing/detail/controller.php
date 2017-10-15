<?php
namespace content_a\billing\detail;

class controller extends  \content_a\main\controller
{

	public function ready()
	{


		$this->get("detail", "detail")->ALL("/^billing\/detail$/");

		$this->post("detail")->ALL("/^billing\/detail$/");
	}
}
?>