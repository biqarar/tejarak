<?php
namespace content_a\member\avatar;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	public function _route()
	{
		parent::_route();

		$this->get(false, 'avatar')->ALL("/.*/");
		$this->post('avatar')->ALL("/.*/");
	}
}
?>