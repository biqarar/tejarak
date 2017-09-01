<?php
namespace content_school\profile;

class controller extends \content_school\main\controller
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