<?php
namespace content_a\convert;
use \lib\debug;
use \lib\utility;
use \lib\utility\jdate;

class model extends \content_a\main\model
{
	public function convert()
	{

		$get_all_hours = "SELECT * FROM hours";
		$get_all_hours = \lib\db::get($get_all_hours, null, false, 'tejarak-arvan');
		$querys = [];


		foreach ($get_all_hours as $key => $value)
		{
			$temp                      = [];
			$temp['user_id']           = (int) $value['user_id'] + 1000000 ;
			$temp['team_id']           = 100001;
			$temp['userteam_id']       = $temp['user_id'];
			$temp['start_userteam_id'] = $temp['userteam_id'];
			$temp['end_userteam_id']   = $temp['userteam_id'];
			$temp['date']              = $value['hour_date'];
			$temp['year']              = date("Y", strtotime($value['hour_date']));
			$temp['month']             = date("m", strtotime($value['hour_date']));
			$temp['day']               = date("d", strtotime($value['hour_date']));
			$temp['shamsi_date']       = jdate::date("Y-m-d", strtotime($value['hour_date']), false, true);
			$temp['shamsi_year']       = jdate::date("Y", strtotime($value['hour_date']), false, true);
			$temp['shamsi_month']      = jdate::date("m", strtotime($value['hour_date']), false, true);
			$temp['shamsi_day']        = jdate::date("d", strtotime($value['hour_date']), false, true);
			$temp['start']             = $value['hour_start'];
			$temp['end']               = $value['hour_end'];
			if($temp['end'])
			{
				$temp['diff']              = (strtotime($temp['date'] . ' '. $temp['end']) - strtotime($temp['date'] . ' '. $temp['start']) ) / 60;
			}
			else
			{
				$temp['diff'] = null;
			}

			$temp['total']             = $value['hour_diff'];
			$temp['minus']             = $value['hour_minus'];
			$temp['plus']              = $value['hour_plus'];
			$temp['type']              = $value['hour_type'];
			$temp['accepted']          = $value['hour_accepted'];
			$temp['date_modified']     = $value['date_modified'];
			$temp['status']            = $value['hour_status'];
			$temp['createdate']        = $temp['date'] . ' ' . $temp['start'];
			$temp['start_gateway_id']  = $temp['user_id'];
			$temp['end_gateway_id']    = $temp['user_id'];
			$temp['enddate']           = $value['hour_date'];
			$temp['endyear']           = date("Y", strtotime($value['hour_date']));
			$temp['endmonth']          = date("m", strtotime($value['hour_date']));
			$temp['endday']            = date("d", strtotime($value['hour_date']));
			$temp['endshamsi_date']    = jdate::date("Y-m-d", strtotime($value['hour_date']), false, true);
			$temp['endshamsi_year']    = jdate::date("Y", strtotime($value['hour_date']), false, true);
			$temp['endshamsi_month']   = jdate::date("m", strtotime($value['hour_date']), false, true);
			$temp['endshamsi_day']     = jdate::date("d", strtotime($value['hour_date']), false, true);
			$set = \lib\db\config::make_set($temp);
			if(!\lib\db::query(" INSERT INTO hours SET $set "))
			{
				var_dump($temp);
				var_dump(\lib\debug::compile());
				exit();
			}

		}

		var_dump(array_count_values($querys));exit();

		$querys = implode(';', $querys);
		$x = \lib\db::query($querys, true, ['multi_query' => true]);
		var_dump($x);
		exit();

	}
}
?>