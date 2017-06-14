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
		// if the user login redirect to base
		parent::if_login_not_route();
		// check remeber me is set
		// if remeber me is set: login!
		parent::check_remeber_me();

		if(self::get_request_method() === 'get')
		{
			$this->get('enter', 'enter')->ALL();
		}
		elseif(self::get_request_method() === 'post')
		{
			$this->post('enter')->ALL();
		}
		else
		{
			self::error_method('home');
		}
	}
}
?>