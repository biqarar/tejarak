<?php
namespace content_a\setting\security;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function ready()
	{



		$url = \lib\url::directory();

		if($url === 'setting/security')
		{
			\lib\header::status(404);
		}
		$this->get(false, 'security')->ALL("/.*/");
		$this->post('security')->ALL("/.*/");

	}
}
?>