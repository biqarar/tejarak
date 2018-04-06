<?php
namespace content_a\setting\report;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function ready()
	{



		$url = \dash\url::directory();

		if($url === 'setting/report')
		{
			\dash\header::status(404);
		}
		$this->get(false, 'report')->ALL("/.*/");
		$this->post('report')->ALL("/.*/");

	}
}
?>