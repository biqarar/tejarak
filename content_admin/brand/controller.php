<?php
namespace content_admin\brand;

class controller extends \content_admin\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{
		parent::_route();

		$this->get('addbranch', 'addbranch')->ALL("/^([A-Za-z0-9]+)\/addbranch$/");
		$this->post('addbranch')->ALL("/^([A-Za-z0-9]+)\/addbranch$/");

		$this->get('editbranch', 'editbranch')->ALL("/^([A-Za-z0-9]+)\/(([A-Za-z0-9]+))\/edit$/");
		$this->post('editbranch')->ALL("/^([A-Za-z0-9]+)\/([A-Za-z0-9]+)\/edit$/");

		if(
			preg_match("/^([A-Za-z0-9]+)\/([A-Za-z0-9]+)\/edit$/", \lib\router::get_url()) ||
			preg_match("/^([A-Za-z0-9]+)\/addbranch$/", \lib\router::get_url())
		  )
		{
			$this->display_name = 'content_admin\brand\add.html';
		}
		else
		{
			$this->get('dashboard', 'dashboard')->ALL("/.*/");
		}
	}
}
?>