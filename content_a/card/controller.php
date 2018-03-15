<?php
namespace content_a\card;

class controller extends \content_a\main\controller
{
	/**
	 * route
	 */
	function ready()
	{

		$url = \lib\url::directory();
		$this->get()->ALL("/.*/");
	}
}
?>