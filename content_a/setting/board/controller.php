<?php
namespace content_a\setting\board;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{

		parent::_route();

		$url = \lib\router::get_url();

		if($url === 'setting/board')
		{
			\lib\error::page();
		}
		$this->get(false, 'board')->ALL("/^([A-Za-z0-9]+)\/setting\/board$/");
		$this->post('board')->ALL("/^([A-Za-z0-9]+)\/setting\/board$/");

	}
}
?>