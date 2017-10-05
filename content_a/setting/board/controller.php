<?php
namespace content_a\setting\board;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{

		parent::_route();

		$this->get(false, 'board')->ALL("/.*/");
		$this->post('board')->ALL("/.*/");

	}
}
?>