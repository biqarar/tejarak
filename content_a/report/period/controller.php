<?php
namespace content_a\report\period;

class controller extends \content_a\report\controller
{
	/**
	 * rout
	 */
	function _route()
	{
		parent::_route();


		$this->get(false, 'period')->ALL("/^([a-zA-Z0-9]+)\/report\/period$/");
	}
}
?>