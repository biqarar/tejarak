<?php
namespace content_a\member\personal;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	public function _route()
	{
		parent::_route();

		$this->get(false, 'personal')->ALL("/.*/");
		$this->post('personal')->ALL("/.*/");
	}
}
?>