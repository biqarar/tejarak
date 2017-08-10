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

		if
		(
			isset($_SERVER['REMOTE_ADDR']) &&
			isset($_SERVER['SERVER_ADDR']) &&
			in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1', $_SERVER['SERVER_ADDR']])
		)
		{
			if(\lib\option::cronjob('status'))
			{

				$this->post("cronjob")->ALL("/.*/");
				$this->display = false;
			}
		}
		else
		{
			\lib\error::page();
		}

	}
}
?>