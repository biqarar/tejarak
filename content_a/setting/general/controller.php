<?php
namespace content_a\setting\general;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function ready()
	{



		$url = \dash\url::directory();

		if($url === 'setting/general')
		{
			\lib\header::status(404);
		}
		$this->get()->ALL("/.*/");
		$this->post('general')->ALL("/.*/");

	}
}
?>