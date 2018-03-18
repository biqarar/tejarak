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
			\lib\header::status(404);
		}

		$this->get()->ALL("/.*/");
	}
}
?>