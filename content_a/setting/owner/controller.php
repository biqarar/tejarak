<?php
namespace content_a\setting\owner;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{

		parent::_route();

		$url = \lib\router::get_url();

		if($url === 'setting/owner')
		{
			\lib\error::page();
		}
		$this->get(false, 'owner')->ALL("/.*/");
		$this->post('owner')->ALL("/.*/");

	}
}
?>