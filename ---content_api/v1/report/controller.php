<?php
namespace content_api\v1\report;

class controller extends \addons\content_api\home\controller
{
	public function ready()
	{
		$this->get("list")->ALL('v1/report/list');

		$this->get("report")->ALL("/v1\/report\/([^\/].*)/");

	}
}
?>