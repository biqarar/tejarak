<?php
namespace content_enter\username\change;

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

		if(!$this->login('username'))
		{
			self::error_page('username');
		}

		// parent::_route();
		$this->get()->ALL('username/change');
		$this->post('username')->ALL('username/change');


	}
}
?>