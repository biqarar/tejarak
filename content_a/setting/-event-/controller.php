<?php
namespace content_a\setting\event;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function ready()
	{



		$url = \dash\url::directory();

		if($url === 'setting/event')
		{
			\lib\header::status(404);
		}
		$this->get(false, 'event')->ALL("/.*/");
		$this->post('event')->ALL("/.*/");

	}
}
?>