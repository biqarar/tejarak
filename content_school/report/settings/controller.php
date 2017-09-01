<?php
namespace content_school\report\settings;

class controller extends \content_school\report\controller
{
	/**
	 * rout
	 */
	function _route()
	{
		parent::_route();
		$this->get(false, 'settings')->ALL("/^([a-zA-Z0-9]+)\/report\/settings$/");
		$this->post('settings')->ALL("/^([a-zA-Z0-9]+)\/report\/settings$/");
	}
}
?>