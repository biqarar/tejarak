<?php
namespace content_enter\verify\what;


class controller extends \content_enter\main\controller
{
	public function _route()
	{
		// if the user is login redirect to base
		parent::if_login_not_route();
		
		$this->get()->ALL('verify/what');
	}
}
?>