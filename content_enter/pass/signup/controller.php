<?php
namespace content_enter\pass\signup;

class controller extends \content_enter\main\controller
{
	/**
	 * check route of account
	 * @return [type] [description]
	 */
	function _route()
	{
		// parent::_route();
		$this->get('pass', 'pass')->ALL('pass/signup');
		$this->post('pass')->ALL('pass/signup');
	}
}
?>