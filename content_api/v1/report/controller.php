<?php
namespace content_api\v1\report;

class controller extends \mvc\controller
{
	public function _route()
	{
		$this->get("list")->ALL('v1/report/list');
		$this->get("last_trafic")->ALL('v1/report/last_trafic');
		$this->get("enter_exit")->ALL('v1/report/enter_exit');
	}
}
?>