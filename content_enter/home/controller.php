<?php
namespace content_enter\home;

class controller extends \content_enter\main\controller
{
	/**
	 * check route of account
	 * @return [type] [description]
	 */
	function _route()
	{
		// parent::_route();
		$this->get('enter', 'enter')->ALL();
		$this->post('enter')->ALL();
	}
}
?>