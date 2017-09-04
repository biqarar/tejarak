<?php
namespace content_s\studentpanel;

class controller extends \content_s\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{

		parent::_route();

		$url = \lib\router::get_url();

		if($url === 'studentpanel')
		{
			\lib\error::page();
		}

		$this->get(false, 'panel')->ALL("/^([A-Za-z0-9]+)\/student\/panel\=([a-zA-Z0-9]+)$/");
	}
}
?>