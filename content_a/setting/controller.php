<?php
namespace content_a\setting;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{

		parent::_route();

		$url = \lib\router::get_url();

		if($url === 'setting')
		{
			\lib\error::page();
		}

		$this->get()->ALL("/.*/");
	}
}
?>