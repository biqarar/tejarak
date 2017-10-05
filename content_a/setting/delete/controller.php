<?php
namespace content_a\setting\delete;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{

		parent::_route();

		$url = \lib\router::get_url();

		if($url === 'setting/delete')
		{
			\lib\error::page();
		}
		$this->get(false, 'delete')->ALL("/^([A-Za-z0-9]+)\/setting\/delete$/");
		$this->post('delete')->ALL("/^([A-Za-z0-9]+)\/setting\/delete$/");

	}
}
?>