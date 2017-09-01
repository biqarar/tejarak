<?php
namespace content_school\report\year;

class controller extends \content_school\report\controller
{
	/**
	 * rout
	 */
	function _route()
	{
		parent::_route();

		$this->get(false, 'year')->ALL("/^([a-zA-Z0-9]+)\/report\/year$/");
	}
}
?>