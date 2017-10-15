<?php
namespace content_a\card;

class controller extends \content_a\main\controller
{
	/**
	 * route
	 */
	function ready()
	{

		$url = \lib\router::get_url();
		$this->get()->ALL("/.*/");
	}
}
?>