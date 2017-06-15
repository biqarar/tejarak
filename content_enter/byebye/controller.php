<?php
namespace content_enter\byebye;


class controller extends \content_enter\main\controller
{
	public function _route()
	{
		// if the user is login redirect to base
		parent::if_login_not_route();
		// if just user from delete page come here
		if(!self::done_step('delete'))
		{
			self::error_page('byebye');
		}
	}
}
?>