<?php
namespace content_enter\username\set;

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

		if($this->login('username'))
		{
			self::error_page('username');
		}

		// parent::_route();
		$this->get('username')->ALL('username/set');
		$this->post('username')->ALL('username/set');


	}
}
?>