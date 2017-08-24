<?php
namespace content_a\option;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{

		parent::_route();

		$url = \lib\router::get_url();

		if($url === 'option')
		{
			\lib\error::page();
		}

		$this->get()->ALL("/^([A-Za-z0-9]+)\/option$/");
	}
}
?>