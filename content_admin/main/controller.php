<?php
namespace content_admin\main;

class controller extends \mvc\controller
{

	/**
	 * rout
	 */
	function _route()
	{

		if(!$this->access('admin'))
		{
			\lib\error::access(T_("Access denied"));
		}
	}
}
?>