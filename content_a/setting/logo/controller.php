<?php
namespace content_a\setting\logo;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{

		parent::_route();

		$url = \lib\router::get_url();

		if($url === 'setting/logo')
		{
			\lib\error::page();
		}
		$this->get(false, 'logo')->ALL("/^([A-Za-z0-9]+)\/setting\/logo$/");
		$this->post('logo')->ALL("/^([A-Za-z0-9]+)\/setting\/logo$/");

	}
}
?>