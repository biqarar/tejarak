<?php
namespace content_enter\pass\recovery;

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
		if(self::done_step('mobile') && self::user_data('user_pass'))
		{
			// parent::_route();
			$this->get('pass')->ALL('pass/recovery');
			$this->post('pass')->ALL('pass/recovery');
		}
		else
		{
			// make page error or redirect
			self::error_page('pass/recovery');
		}
	}
}
?>