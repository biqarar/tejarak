<?php
namespace content_school\option\owner;

class controller extends \content_school\main\controller
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