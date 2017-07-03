<?php
namespace content_enter\delete;

class controller extends \content_enter\main\controller
{
	/**
	 * check route of account
	 * @return [type] [description]
	 */
	function _route()
	{
		$this->get()->ALL();
		$this->post('delete')->ALL();
	}
}
?>