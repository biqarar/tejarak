<?php
namespace content_a\report\u;

class controller extends \content_a\report\controller
{
	/**
	 * rout
	 */
	function _route()
	{
		parent::_route();
		$this->get(false, 'u')->ALL("/^([a-zA-Z0-9]+)\/report\/u$/");
	}
}
?>