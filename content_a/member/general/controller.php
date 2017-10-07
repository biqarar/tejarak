<?php
namespace content_a\member\general;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	public function _route()
	{
		parent::_route();

		$this->get(false, 'general')->ALL("/.*/");
		$this->post('general')->ALL("/.*/");
	}
}
?>