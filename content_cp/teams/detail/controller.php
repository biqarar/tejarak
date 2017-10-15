<?php
namespace content_cp\teams\detail;

class controller extends \mvc\controller
{
	public function ready()
	{
		\lib\permission::access('cp:user:detail', 'block');

		$this->get(false, "detail")->ALL();

		$this->get("load", "detail")->ALL("/teams\/detail\/(\d+)/");

		$this->post('detail')->ALL();
		$this->post('detail')->ALL("/teams\/detail\/(\d+)/");
	}
}
?>