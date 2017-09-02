<?php
namespace content_s\option\owner;

class controller extends \content_s\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{

		parent::_route();

		$url = \lib\router::get_url();

		if($url === 'option/owner')
		{
			\lib\error::page();
		}
		$this->get(false, 'owner')->ALL("/^([A-Za-z0-9]+)\/option\/owner$/");
		$this->post('owner')->ALL("/^([A-Za-z0-9]+)\/option\/owner$/");

	}
}
?>