<?php
namespace content_s\score;

class controller extends \content_s\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{

		parent::_route();

		$url = \lib\router::get_url();

		if($url === 'score')
		{
			\lib\error::page();
		}

		$this->get(false, 'score')->ALL("/^([A-Za-z0-9]+)\/score\=([a-zA-Z0-9]+)$/");
		$this->post('score')->ALL("/^([A-Za-z0-9]+)\/score\=([a-zA-Z0-9]+)$/");
	}
}
?>