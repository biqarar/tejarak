<?php
namespace content_enter\pass\signup;

class controller extends \content_enter\main\controller
{
	/**
	 * check route of account
	 * @return [type] [description]
	 */
	function _route()
	{
		// if the user is login redirect to base
		parent::if_login_not_route();
		// if step mobile is done
		if(self::done_step('mobile') && !self::user_data('user_pass'))
		{
			// parent::_route();
			$this->get('pass')->ALL('pass/signup');
			$this->post('pass')->ALL('pass/signup');
		}
		else
		{
			// make page error or redirect
			self::error_page('pass/signup');
		}
	}
}
?>