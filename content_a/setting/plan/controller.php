<?php
namespace content_a\setting\plan;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{

		parent::_route();

		$url = \lib\router::get_url();

		if($url === 'setting/plan')
		{
			\lib\error::page();
		}
		$this->get(false, 'plan')->ALL("/^([A-Za-z0-9]+)\/setting\/plan$/");
		$this->post('plan')->ALL("/^([A-Za-z0-9]+)\/setting\/plan$/");

	}
}
?>