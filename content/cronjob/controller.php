<?php
namespace content\cronjob;
use \lib\saloos;

class controller extends \content\main\controller
{
	function ready()
	{
		if(isset($_SERVER['REQUEST_METHOD']) && mb_strtolower($_SERVER['REQUEST_METHOD']) === 'get')
		{
			\dash\header::status(404);
		}

		if(\dash\url::isLocal())
		{
			return;
		}

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
			if(\dash\option::config('cronjob','status'))
			{
				$this->post("cronjob")->ALL("/.*/");
				$this->display = false;
			}
		}
		else
		{
			\dash\utility\telegram::sendMessage("@tejarak_monitor", "#ERROR\n".  json_encode($_SERVER, JSON_UNESCAPED_UNICODE));
			\dash\header::status(404);
		}

	}
}
?>