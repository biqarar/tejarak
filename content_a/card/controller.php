<?php
namespace content_a\card;

class controller extends \content_a\main\controller
{
	/**
	 * route
	 */
	function _route()
	{
		parent::_route();
		$url = \lib\router::get_url();
		$this->get()->ALL();
	}
}
?>