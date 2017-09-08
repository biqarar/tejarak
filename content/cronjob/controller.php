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

		// if(Tld === 'dev')
		// {
		// 	return;
		// }

		if
		(
			preg_match("/^127\\.0\\.0\\.\d+$/", $_SERVER['SERVER_ADDR']) ||
			(
				isset($_SERVER['REMOTE_ADDR']) &&
				isset($_SERVER['SERVER_ADDR']) &&
				$_SERVER['REMOTE_ADDR'] === $_SERVER['SERVER_ADDR']
			)
		)
		{
			if(\lib\option::config('cronjob','status'))
			{
				$this->post("cronjob")->ALL("/.*/");
				$this->display = false;
			}
		}
		else
		{
			\lib\utility\telegram::sendMessage("@tejarak_monitor", "#ERROR\n".  json_encode($_SERVER, JSON_UNESCAPED_UNICODE));
			\lib\error::page();
		}

	}
}
?>