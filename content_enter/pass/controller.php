<?php
namespace content_enter\pass;


class controller extends \content_enter\main\controller
{
	public function _route()
	{
		$this->post('check')->ALL('pass');
	}
}
?>