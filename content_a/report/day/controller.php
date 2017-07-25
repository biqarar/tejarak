<?php
namespace content_a\report\day;

class controller extends \content_a\report\controller
{
	/**
	 * rout
	 */
	function _route()
	{
		parent::_route();


		$this->get(false, 'day')->ALL("/^([a-zA-Z0-9]+)\/report\/day$/");
	}
}
?>