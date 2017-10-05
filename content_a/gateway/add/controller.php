<?php
namespace content_a\gateway\add;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	public function _route()
	{
		parent::_route();

		$this->get(false, 'add')->ALL("/.*/");
		$this->post('add')->ALL("/.*/");
	}
}
?>