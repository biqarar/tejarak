<?php
namespace content_admin\home;

class controller extends \content_admin\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{
		parent::_route();

		$url = \lib\router::get_url();
		if(preg_match("/^[A-Za-z0-9]+\/addbranch$/", $url))
		{
			\lib\router::set_controller("content_admin\brand\controller");
			return;
		}

		if(preg_match("/^[A-Za-z0-9]+\/[A-Za-z0-9]+\/edit$/", $url))
		{
			\lib\router::set_controller("content_admin\brand\controller");
			return;
		}

		$route = $this->model()->find_company($url);
		if($route)
		{
			\lib\router::set_controller("content_admin\brand\controller");
			return;
		}

	}
}
?>