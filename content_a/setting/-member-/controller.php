<?php
namespace content_a\setting\member;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function ready()
	{



		$url = \dash\url::directory();

		if($url === 'setting/member')
		{
			\lib\header::status(404);
		}
		$this->get(false, 'member')->ALL("/.*/");
		$this->post('member')->ALL("/.*/");

	}
}
?>