<?php
namespace content_a\report\settings;

class controller extends \content_a\report\controller
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