<?php
namespace content_a\setting\event;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function ready()
	{



		$url = \lib\url::directory();

		if($url === 'setting/event')
		{
			\lib\error::page();
		}
		$this->get(false, 'event')->ALL("/.*/");
		$this->post('event')->ALL("/.*/");

	}
}
?>