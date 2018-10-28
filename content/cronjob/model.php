<?php
namespace content\cronjob;


class model
{
	/**
	 * save cronjob form
	 */
	public static function post()
	{

		if(!\dash\option::config('cronjob','status'))
		{
			return;
		}

		$url = \dash\request::get('type');

		switch ($url)
		{
			// case 'pinger':
			// 	self::pinger();
			// 	break;

			case 'report':
				self::report();
				break;

			case 'calc':
				self::calc();
				break;

			case 'notification':
				(new \lib\utility\notifications)->send();
				break;

			default:
				return;
				break;
		}
	}


	/**
	 * check in this time have any report or no
	 */
	public static function report()
	{

		$time_now    = date("H:i");
		$query       = "SELECT teams.id AS `id` FROM teams WHERE teams.timed_auto_report = '$time_now'";
		$check_exist = \dash\db::get($query, 'id');

		if($check_exist && is_array($check_exist))
		{
			foreach ($check_exist as $key => $value)
			{
				$msg = new \lib\utility\message($value);
				$msg->send_by('telegram');
				$msg->type('timed_auto_report');
				$msg->send();
			}
		}
		else
		{
			return;
		}
	}


	public static function calc()
	{
		$time_now = date("H:i");
		$date     = date("Y-m-d H:i:s");
		$query    =
		"
			SELECT teams.id AS `id` FROM teams
			WHERE DAY(teams.startplan)    = DAY('$date')
			AND   HOUR(teams.startplan)   = HOUR('$time_now')
			AND   MINUTE(teams.startplan) = MINUTE('$time_now')
		";

		$check_exist = \dash\db::get($query, 'id');

		if($check_exist && is_array($check_exist))
		{
			foreach ($check_exist as $key => $value)
			{
				$calc = new \lib\utility\calc($value);
				$calc->save(true);
				$calc->notify(true);
				$calc->type('calc_invoice');
				$calc->calc();
			}
		}
		else
		{
			return;
		}
	}


	/**
	 * ping every 1 min
	 */
	public static function pinger()
	{
		$host = 'sarshomar.com';

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


		// $default_send_service = \lib\utility\telegram::$force_send_telegram_service;

		if($run)
		{
			$this->set_last_pinged_time();
		}

		// \lib\utility\telegram::$force_send_telegram_service = true;
		// \lib\utility\telegram::$bot_key                     = '123';
		// \lib\utility\telegram::$save_log                    = false;

		// \lib\utility\telegram::sendMessage("@tejarak_monitor", $msg);

		// // \lib\utility\telegram::$force_send_telegram_service = $default_send_service;
		// \lib\utility\telegram::$bot_key                     = null;
		// \lib\utility\telegram::$save_log                    = true;


	}


	/**
	 * Gets the last pinged time.
	 */
	public static function get_last_pinged_time()
	{
		$date = date("Y-m-d H:i:s");
		$url  = __DIR__ . '/last_ping_time.txt';

		if(!\dash\file::exists($url))
		{
			\dash\file::write($url, $date);
		}
		else
		{
			$date = \dash\file::read($url);
		}
		return $date;
	}

	/**
	 * Sets the last pinged time.
	 */
	public static function set_last_pinged_time()
	{
		$date = date("Y-m-d H:i:s");
		$url  = __DIR__ . '/last_ping_time.txt';
		\dash\file::write($url, $date);
	}
}