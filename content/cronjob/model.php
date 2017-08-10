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
}