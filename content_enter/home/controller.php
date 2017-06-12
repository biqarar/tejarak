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
		if(self::get_request_method() === 'get')
		{
			if($this->login())
			{
				self::go_to($this->url('base'));
				return;
			}
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