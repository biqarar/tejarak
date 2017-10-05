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
		$this->get(false, 'owner')->ALL("/^([A-Za-z0-9]+)\/setting\/owner$/");
		$this->post('owner')->ALL("/^([A-Za-z0-9]+)\/setting\/owner$/");

	}
}
?>