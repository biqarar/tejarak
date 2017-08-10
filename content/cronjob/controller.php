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
		// if
		// (
		// 	isset($_SERVER['REMOTE_ADDR']) &&
		// 	isset($_SERVER['SERVER_ADDR']) &&
		// 	in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1', $_SERVER['SERVER_ADDR']])
		// )
		// {


			if(\lib\option::cronjob('status'))
			{

				$this->pinger();

				$this->post("cronjob")->ALL("/.*/");
				$this->display = false;
			}
		// }
		// else
		// {
		// 	\lib\error::page();
		// }

	}

	/**
	 * ping every 1 min
	 */
	public function pinger()
	{
		$host = 'tejarak.com';

		$ping = new \lib\utility\ping($host);

		$latency = $ping->ping();

		$saved_time = $this->get_last_pinged_time();

		$time_now = date("Y-m-d H:i:s");

		$msg = ClientIP. "\n";
		$msg .= $host. "\n";

		if ($latency !== false)
		{
			$run = true;
		  	$msg .= 'Latency is ' . $latency . ' ms';
		}
		else
		{
			$run = false;
			$msg .= "🔴 SERVER IS #DOWN!";
		}

		$timediff = strtotime($time_now) - strtotime($saved_time);

		if($timediff > 65)
		{
			$temp_msg = "\n 🔴 #I_AM_DOWN! 🔴 \n";
			$temp_msg .= " Last runtime: ". $saved_time;
			$msg = $temp_msg;
		}

		$tg_url = 'https://api.telegram.org/bot401647634:AAEUeTV5E7CYxZth-6TOWFHdjzABwVavJS0';
		\lib\utility\telegram::$force_send_telegram_service = true;
		\lib\utility\telegram::$telegram_api_url = $tg_url;
		\lib\utility\telegram::sendMessage(33263188, $msg);
		\lib\utility\telegram::sendMessage(33263188, json_encode($_SERVER, JSON_UNESCAPED_UNICODE));
		\lib\utility\telegram::sendMessage("@tejarak_monitor", $msg);

		if($run)
		{
			$this->set_last_pinged_time();
		}

	}


	/**
	 * Gets the last pinged time.
	 */
	public function get_last_pinged_time()
	{
		$date = date("Y-m-d H:i:s");
		$url  = __DIR__ . '/last_ping_time.txt';

		if(!\lib\utility\file::exists($url))
		{
			\lib\utility\file::write($url, $date);
		}
		else
		{
			$date = \lib\utility\file::read($url);
		}
		return $date;
	}

	/**
	 * Sets the last pinged time.
	 */
	public function set_last_pinged_time()
	{
		$date = date("Y-m-d H:i:s");
		$url  = __DIR__ . '/last_ping_time.txt';
		\lib\utility\file::write($url, $date);
	}
}
?>