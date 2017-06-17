<?php
namespace content_enter\delete;

class controller extends \content_enter\main\controller
{
	/**
	 * check route of account
	 * @return [type] [description]
	 */
	function _route()
	{
		// if the user login redirect to base
		parent::if_login_route();

		if(self::get_request_method() === 'get')
		{
			$this->get()->ALL();
		}
		elseif(self::get_request_method() === 'post')
		{
			$this->post('delete')->ALL();
		}
		else
		{
			self::error_method('delete');
		}
	}
}
?>