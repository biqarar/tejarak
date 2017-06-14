<?php
namespace content_enter\verify\what;


class controller extends \content_enter\main\controller
{
	public function _route()
	{
		if(self::done_step('delete'))
		{
			// the user try to delete her account
			// and we can no found any way to send code to he
		}
		else
		{
			// if the user is login redirect to base
			parent::if_login_not_route();

			// check remeber me is set
			// if remeber me is set: login!
			parent::check_remeber_me();
		}

		$this->get()->ALL('verify/what');
	}
}
?>