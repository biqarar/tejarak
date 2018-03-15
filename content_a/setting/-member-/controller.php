<?php
namespace content_a\setting\member;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function ready()
	{



		$url = \lib\url::directory();

		if($url === 'setting/member')
		{
			\lib\error::page();
		}
		$this->get(false, 'member')->ALL("/.*/");
		$this->post('member')->ALL("/.*/");

	}
}
?>