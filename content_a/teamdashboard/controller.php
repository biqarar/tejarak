<?php
namespace content_a\teamdashboard;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function ready()
	{



		$url = \lib\url::directory();

		if($url === 'teamdashboard')
		{
			\lib\error::page();
		}

		$this->get()->ALL("/.*/");
	}
}
?>