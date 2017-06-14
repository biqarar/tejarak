<?php
namespace content_enter\pass;


class controller extends \content_enter\main\controller
{
	public function _route()
	{
		// if the user is login redirect to base
		parent::if_login_not_route();

		// check remeber me is set
		// if remeber me is set: login!
		parent::check_remeber_me();

		if((self::done_step('mobile') || self::done_step('username')) && self::user_data('user_pass'))
		{
			$this->post('check')->ALL('pass');
		}
		else
		{
			self::error_page('pass');
		}
	}
}
?>