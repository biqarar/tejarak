<?php
namespace content_admin\home;

class controller extends \mvc\controller
{

	/**
	 * rout
	 */
	function _route()
	{
		parent::_route();

		if(!$this->access('admin'))
		{
			\lib\error::access(T_("Access denied"));
		}
	}
}
?>