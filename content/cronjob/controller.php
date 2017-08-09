<?php
namespace content\cronjob;
use \lib\saloos;

class controller extends \content\main\controller
{
	function _route()
	{
		parent::_route();

		if(isset($_SERVER['REQUEST_METHOD']) && mb_strtolower($_SERVER['REQUEST_METHOD']) === 'get')
		{
			\lib\error::page();
		}

		if(\lib\option::cronjob('status'))
		{
			$this->post("cronjob")->ALL("/.*/");
			$this->display = false;
		}
	}
}
?>