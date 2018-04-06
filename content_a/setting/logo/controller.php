<?php
namespace content_a\setting\logo;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function ready()
	{



		$url = \dash\url::directory();

		if($url === 'setting/logo')
		{
			\dash\header::status(404);
		}
		$this->get()->ALL("/.*/");
		$this->post('logo')->ALL("/.*/");

	}
}
?>