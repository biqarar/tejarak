<?php
namespace lib\utility\message\make;


trait lasttraffic
{

	public function lasttraffic()
	{
		$default_language = \lib\language::current();
		$meta             = [];
		$meta['limit']    = 10;
		$meta['team_id']  = $this->team_id;
		$meta['sort']     = ['hourlogs.date DESC', 'hourlogs.id'];
		$meta['order']    = 'DESC';
		$result           = \lib\db\hourlogs::search(null, $meta);
		$count_person     = [];
		$msg              = null;
		$first_log_date   = null;
		if($result && is_array($result))
		{
			$count_person = array_column($result, 'userteam_id');
			$count_person = array_unique($count_person);

			foreach ($result as $key => $value)
			{
				if(isset($value['displayname']))
				{
					if(array_key_exists('type', $value) && array_key_exists('time', $value) && array_key_exists('date', $value))
					{
						if(!$first_log_date)
						{
							if(date("Y-m-d", strtotime($value['date'])) == date("Y-m-d"))
							{
								$msg .= T_("Today");
							}
							else
							{
								$msg .= "\n". \lib\date::fit_lang('l j F Y', strtotime($value['date']) , $default_language);
							}

							$first_log_date = $value['date'];
						}
						else
						{
							if($first_log_date == $value['date'])
							{
							}
							else
							{
								$msg .= "\n\n". \lib\date::fit_lang('l j F Y', strtotime($value['date']) , $default_language);
								$first_log_date = $value['date'];
							}
						}


						if($value['type'] === 'exit')
						{
							// $emoji = "➖";
							$emoji = "💤";
						}
						else
						{
							// $emoji = "➕";
							$emoji = "✅";
						}
						$msg .= "\n". $emoji. " ". $value['displayname'];
						$msg .= " ". \lib\utility\human::number(preg_replace("/\:00$/", '', $value['time']), $default_language);
					}
				}
			}
		}

		if($msg)
		{
			$temp_message = $msg;
			$msg = "#". T_("Last_traffic");
			$msg .= "\n". \lib\date::fit_lang('l j F Y H:i', time() , $default_language) . "\n";
			$msg .= $temp_message;
			$msg .= "\n👥 ". \lib\utility\human::number(count($count_person), $default_language);
		}

		return $msg;
	}

}
?>