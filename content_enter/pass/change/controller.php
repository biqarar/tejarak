<?php
namespace content_enter\pass\change;

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


		$this->get()->ALL('pass/change');
		$this->post('pass')->ALL('pass/change');

	}
}
?>