<?php
namespace content_api\v1\report;

class controller extends \mvc\controller
{
	public function _route()
	{
		$this->get("list")->ALL('v1/report/list');

		$this->get("report")->ALL("/v1\/report\/([^\/].*)/");

	}
}
?>