<?php
namespace content\cronjob;
use \lib\debug;
use \lib\utility;

class model extends \mvc\model
{
	/**
	 * save cronjob form
	 */
	public function post_cronjob($_args = null)
	{

		$url = \lib\router::get_url(1);

		switch ($url)
		{
			case 'report':
				$this->report();
				break;
			case 'calc':
				$this->calc();
			default:
				return;
				break;
		}
	}


	/**
	 * check in this time have any report or no
	 */
	public function report()
	{

		$time_now    = date("H:i");
		$query       = "SELECT teams.id AS `id` FROM teams WHERE teams.timed_auto_report = '$time_now'";
		$check_exist = \lib\db::get($query, 'id');

		if($check_exist && is_array($check_exist))
		{
			foreach ($check_exist as $key => $value)
			{
				$msg = new \lib\utility\message($value);
				$msg->message_type('timed_auto_report');
				$msg->send();
			}
		}
		else
		{
			return;
		}
	}


	public function calc()
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

		$check_exist = \lib\db::get($query, 'id');

		if($check_exist && is_array($check_exist))
		{
			foreach ($check_exist as $key => $value)
			{
				$calc = new \lib\utility\calc($value);
				$calc->save(true);
				$calc->notify(true);
				$calc->type('calc_invoice');
				$calc->notify_type('multi');
				$calc->calc();
			}
			\lib\utility\calc::notify_send();
		}
		else
		{
			return;
		}
	}
}