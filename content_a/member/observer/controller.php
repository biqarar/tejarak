<?php
namespace content_a\member\observer;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	public function _route()
	{
		parent::_route();

		$this->get(false, 'observer')->ALL("/.*/");
		$this->post('observer')->ALL("/.*/");
	}
}
?>