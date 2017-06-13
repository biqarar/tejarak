<?php
namespace content_enter\pass;


class controller extends \content_enter\main\controller
{
	public function _route()
	{
		// if the user is login redirect to base
		parent::if_login_not_route();
		
		$this->post('check')->ALL('pass');
	}
}
?>