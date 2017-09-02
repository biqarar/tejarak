<?php
namespace content_s\profile\parent;

class controller extends \content_s\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{
		parent::_route();
		$this->get(false, 'parent')->ALL('profile/parent');
		$this->post('parent')->ALL('profile/parent');
	}
}
?>