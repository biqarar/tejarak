<?php
namespace content_a\report\last;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{
		parent::_route();
		$this->get(false, 'last')->ALL("/^([a-zA-Z0-9]+)\/report\/last$/");
	}
}
?>