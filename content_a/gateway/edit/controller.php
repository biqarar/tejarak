<?php
namespace content_a\gateway\edit;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	public function _route()
	{
		parent::_route();

		$this->get(false, 'edit')->ALL("/.*/");
		$this->post('edit')->ALL("/.*/");

	}
}
?>