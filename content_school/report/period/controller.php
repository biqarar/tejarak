<?php
namespace content_school\report\period;

class controller extends \content_school\report\controller
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