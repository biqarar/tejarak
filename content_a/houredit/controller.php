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
		// show list of request time
		$this->get(false, 'showRequestList')->ALL("/^([a-zA-Z0-9]+)\/houredit\/list$/");
		$url = \lib\router::get_url();
		if(preg_match("/^([a-zA-Z0-9]+)\/houredit\/list$/", $url))
		{
			$this->display_name = 'content_a\\houredit\\list.html';
		}


		// show detail of one request
		$this->get(false, 'showRequestDetail')->ALL("/^([a-zA-Z0-9]+)\/houredit\/detail\=([a-zA-Z0-9]+)$/");
		$url = \lib\router::get_url();
		if(preg_match("/^([a-zA-Z0-9]+)\/houredit\/detail\=([a-zA-Z0-9]+)$/", $url))
		{
			$this->display_name = 'content_a\\houredit\\detail.html';
		}

		$this->delete('request')->ALL("/^([a-zA-Z0-9]+)\/houredit\/remove\=([a-zA-Z0-9]+)$/");
	}
}
?>