<?php
namespace content_a\profile;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{
		parent::_route();
		$this->get()->ALL('profile');
		$this->post('profile')->ALL('profile');
	}
}
?>