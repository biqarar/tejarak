<?php
namespace content_s\report\last;

class controller extends \content_s\report\controller
{
	/**
	 * rout
	 */
	function _route()
	{
		parent::_route();

		$this->get(false, 'last')->ALL("/^([a-zA-Z0-9]+)\/report\/last$/");

		$this->post('last')->ALL("/^([a-zA-Z0-9]+)\/report\/last$/");
	}
}
?>