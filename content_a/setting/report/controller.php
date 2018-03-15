<?php
namespace content_a\setting\report;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function ready()
	{



		$url = \lib\url::directory();

		if($url === 'setting/report')
		{
			\lib\error::page();
		}
		$this->get(false, 'report')->ALL("/.*/");
		$this->post('report')->ALL("/.*/");

	}
}
?>