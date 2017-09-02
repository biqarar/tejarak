<?php
namespace content_s\option;

class controller extends \content_s\main\controller
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