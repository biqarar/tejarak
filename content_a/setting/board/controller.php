<?php
namespace content_a\setting\board;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function ready()
	{



		$this->get()->ALL("/.*/");
		$this->post('board')->ALL("/.*/");

	}
}
?>