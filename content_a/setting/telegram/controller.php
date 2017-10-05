<?php
namespace content_a\setting\telegram;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{

		parent::_route();

		$url = \lib\router::get_url();

		if($url === 'setting/telegram')
		{
			\lib\error::page();
		}
		$this->get(false, 'telegram')->ALL("/^([A-Za-z0-9]+)\/setting\/telegram$/");
		$this->post('telegram')->ALL("/^([A-Za-z0-9]+)\/setting\/telegram$/");

	}
}
?>