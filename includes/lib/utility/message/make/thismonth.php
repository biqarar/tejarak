<?php
namespace lib\utility\message\make;
use \lib\utility;
use \lib\utility\human;
use \lib\debug;
use \lib\db;


trait thismonth
{

	public function thismonth()
	{

		$args['team_id']        = $this->team_id;
		$args['user_id']        = null;
		$args['userteam_id']    = null;
		$args['year']           = \lib\utility\jdate::date("Y", false, false);
		$args['month']          = \lib\utility\jdate::date("m", false, false);;
		$args['date_is_shamsi'] = true;

		$result = \lib\db\hours::sum_month_time($args);
		$msg = null;
		$total_diff = 0;
		if($result && is_array($result))
		{
			foreach ($result as $key => $value)
			{
				if(isset($value['displayname']) && array_key_exists('diff', $value))
				{
					$total_diff += intval($value['diff']);
					$msg .= "\n💠 ". $value['displayname']. " ". human::number($value['diff'], \lib\define::get_language());
				}
			}
		}
		if($msg)
		{
			$msg = "#". T_("This_month"). "\n". \lib\utility::date('l j F Y H:i', time() , 'current') . "\n\n". $msg;
			$msg .= "\n🕰 ". human::number($total_diff, \lib\define::get_language());
		}
		return $msg;
	}
}
?>