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
		$this->get(false, 'plan')->ALL("/.*/");
		$this->post('plan')->ALL("/.*/");

	}
}
?>