<?php
namespace lib\utility\message\make;


trait thismonth
{

	public function thismonth()
	{
		$default_language = \lib\language::get_language();

		$args['team_id']        = $this->team_id;
		$args['user_id']        = null;
		$args['userteam_id']    = null;
		$args['year']           = \lib\utility\jdate::date("Y", false, false);
		$args['month']          = \lib\utility\jdate::date("m", false, false);
		$args['date_is_shamsi'] = true;

		$result = \lib\db\hours::sum_month_time($args);
		$msg = null;
		$total_diff = 0;

		if($result && is_array($result))
		{
			$count_person = array_column($result, 'userteam_id');
			$count_person = array_unique($count_person);

			foreach ($result as $key => $value)
			{

				if(isset($value['displayname']) && array_key_exists('diff', $value))
				{
					$total_diff += intval($value['diff']);
					$msg .= "\n💠 ". $value['displayname']. " ". \lib\utility\human::time($value['diff'],'number', $default_language);
				}
			}
		}
		if($msg)
		{
			$temp_message = $msg;
			$msg = "#".	T_("Current_month");
			$msg .= " ". \lib\utility::date('F', time() , 'current');
			$msg .= "\n". \lib\utility::date('l j F Y H:i', time() , 'current');
			$msg .= "\n". $temp_message;
			$msg .= "\n🕰 ". \lib\utility\human::time($total_diff,'number', $default_language);
			$msg .= "\n👥 ". \lib\utility\human::number(count($count_person), $default_language);
		}
		return $msg;
	}
}
?>