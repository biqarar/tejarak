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

		// if this step is locked go to error page and return
		if(self::lock('pass/recovery'))
		{
			self::error_page('pass/recovery');
			return;
		}
		// if the user is login redirect to base
		parent::if_login_not_route();

		// check remeber me is set
		// if remeber me is set: login!
		parent::check_remeber_me();
		// parent::_route();
		$this->get('pass')->ALL('pass/recovery');
		$this->post('pass')->ALL('pass/recovery');
	}
}
?>