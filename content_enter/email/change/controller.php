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

		$this->get()->ALL('email/change');
		$this->post('email')->ALL('email/change');

	}
}
?>