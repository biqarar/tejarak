<?php
namespace content_a\teamdashboard;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function ready()
	{



		$url = \dash\url::directory();

		if($url === 'teamdashboard')
		{
			\dash\header::status(404);
		}

		$this->get()->ALL("/.*/");
	}
}
?>