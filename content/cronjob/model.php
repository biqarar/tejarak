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
		if
		(
			isset($_SERVER['REMOTE_ADDR']) &&
			isset($_SERVER['SERVER_ADDR']) &&
			in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1', $_SERVER['SERVER_ADDR']])
		)
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
		else
		{
			\lib\error::page();
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
				// make timed auto report and send by telegram
				\lib\db\teams::timed_auto_report($value);
			}
		}
		else
		{
			return;
		}
	}
}