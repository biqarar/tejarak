<?php
namespace content_enter\email\set;

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

		// parent::_route();

		$this->get()->ALL('email/set');

		$this->post('email')->ALL('email/set');

	}
}
?>