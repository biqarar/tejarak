<?php
namespace content_enter\hook;

class controller extends  \mvc\controller
{

	public function corridor()
	{
		if(!$this->method && mb_strtolower($_SERVER['REQUEST_METHOD']) !== 'post')
		{
			\lib\error::method($_SERVER['REQUEST_METHOD'] . " not allowed");
		}
	}

	public function _route()
	{
		$this->post('user')->ALL();
	}

}
?>