<?php
namespace content_a\teamdashboard;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{

		parent::_route();

		$url = \lib\router::get_url();

		if($url === 'teamdashboard')
		{
			\lib\error::page();
		}

		$this->get()->ALL("/.*/");
	}
}
?>