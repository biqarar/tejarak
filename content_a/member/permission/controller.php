<?php
namespace content_a\member\permission;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	public function _route()
	{
		parent::_route();

		$this->get(false, 'permission')->ALL("/.*/");
		$this->post('permission')->ALL("/.*/");
	}
}
?>