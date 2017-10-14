<?php
namespace content_a\member\removed;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	public function _route()
	{
		parent::_route();

		$this->get(false, 'list')->ALL("/.*/");
	}
}
?>