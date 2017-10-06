<?php
namespace content_a\setting\report;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{

		parent::_route();

		$url = \lib\router::get_url();

		if($url === 'setting/report')
		{
			\lib\error::page();
		}
		$this->get(false, 'report')->ALL("/.*/");
		$this->post('report')->ALL("/.*/");

	}
}
?>