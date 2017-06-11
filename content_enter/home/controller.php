<?php
namespace content_enter\home;

class controller extends \content_enter\main\controller
{
	/**
	 * check route of account
	 * @return [type] [description]
	 */
	function _route()
	{
		// parent::_route();
		if(self::check_valid_route('mobile'))
		{
			$this->get('enter', 'enter')->ALL();
			$this->post('enter')->ALL();
		}
		else
		{
			\lib\error::page(T_("Unavalible"));
		}
	}
}
?>