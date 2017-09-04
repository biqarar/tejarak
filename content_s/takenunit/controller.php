<?php
namespace content_s\takenunit;

class controller extends \content_s\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{

		parent::_route();

		$url = \lib\router::get_url();

		if($url === 'takenunit')
		{
			\lib\error::page();
		}

		$this->get(false, 'takenunit')->ALL("/^([A-Za-z0-9]+)\/student\/takenunit\=([a-zA-Z0-9]+)$/");
		$this->post('takenunit')->ALL("/^([A-Za-z0-9]+)\/student\/takenunit\=([a-zA-Z0-9]+)$/");
	}
}
?>