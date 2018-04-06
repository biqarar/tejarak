<?php
namespace content_a\card;

class controller extends \content_a\main\controller
{
	/**
	 * route
	 */
	function ready()
	{

		$url = \dash\url::directory();
		$this->get()->ALL("/.*/");
	}
}
?>