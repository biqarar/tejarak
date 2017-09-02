<?php
namespace content_s\profile;

class controller extends \content_s\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{
		parent::_route();
		$this->get(false, 'profile')->ALL('profile');
		$this->post('profile')->ALL('profile');
	}
}
?>