<?php
namespace content\hours;

class controller extends \content\main\controller
{
	// for routing check
	function _route()
	{
		parent::_route();
		$url = \lib\router::get_url();
		if($url === 'hours')
		{
			\lib\error::page();
		}
		$this->get(false, 'show')->ALL($url);
		$this->post('hours')->ALL($url);

	}
}
?>