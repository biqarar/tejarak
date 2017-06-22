<?php
namespace content\hours;

class controller extends \content\main\controller
{
	/**
	 * route hous page
	 */
	public function _route()
	{
		parent::_route();

		$url = \lib\router::get_url();
		// this module name is hours
		// the house url can not be route
		if($url === 'hours')
		{
			\lib\error::page();
		}

		$this->get(false, 'show')->ALL($url);
		$this->post('hours')->ALL($url);


	}
}
?>