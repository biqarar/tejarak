<?php
namespace content_school\report\month;

class controller extends \content_school\report\controller
{
	/**
	 * rout
	 */
	function _route()
	{
		parent::_route();


		$this->get(false, 'month')->ALL("/^([a-zA-Z0-9]+)\/report\/month$/");
	}
}
?>