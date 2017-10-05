<?php
namespace content_a\setting\event;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{

		parent::_route();

		$url = \lib\router::get_url();

		if($url === 'setting/event')
		{
			\lib\error::page();
		}
		$this->get(false, 'event')->ALL("/^([A-Za-z0-9]+)\/setting\/event$/");
		$this->post('event')->ALL("/^([A-Za-z0-9]+)\/setting\/event$/");

	}
}
?>