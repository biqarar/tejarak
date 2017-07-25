<?php
namespace content_a\houredit;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{
		parent::_route();
		$this->get(false, 'showTime')->ALL("/^([a-zA-Z0-9]+)\/houredit(|\=([a-zA-Z0-9]+))$/");
		$this->post('save')->ALL("/^([a-zA-Z0-9]+)\/houredit(|\=([a-zA-Z0-9]+))$/");
	}
}
?>