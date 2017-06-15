<?php
namespace content_enter\email\change;

class controller extends \content_enter\main\controller
{
	/**
	 * check route of account
	 * @return [type] [description]
	 */
	function _route()
	{

		// if the user is login redirect to base
		parent::if_login_route();

		// if the user have not an email can not change her email
		// he must set email
		if(!$this->login('email'))
		{
			$this->redirector()->set_domain()->set_url('enter/email/set')->redirect();
			return;
		}

		$this->get()->ALL('email/change');
		$this->post('change')->ALL('email/change');

	}
}
?>