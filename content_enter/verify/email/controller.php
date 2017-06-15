<?php
namespace content_enter\verify\email;


class controller extends \content_enter\main\controller
{
	public function _route()
	{

		// if this step is locked go to error page and return
		if(self::lock('verify/email'))
		{
			self::error_page('verify/email');
			return;
		}

		// if the user is login redirect to base
		parent::if_login_not_route();

		// check remeber me is set
		// if remeber me is set: login!
		parent::check_remeber_me();


		$this->get()->ALL('verify/email');
	}
}
?>