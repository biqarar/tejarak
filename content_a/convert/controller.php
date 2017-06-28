<?php
namespace content_a\convert;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{
		parent::_route();
		$this->model()->convert();
	}
}
?>