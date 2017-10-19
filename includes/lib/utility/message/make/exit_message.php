<?php
namespace lib\utility\message\make;
use \lib\utility\human;

trait exit_message
{

	/**
	 * make exit message
	 *
	 * @return     string  ( description_of_the_return_value )
	 */
	public function exit_message($_type = null)
	{
		$msg = null;
		if($this->displayname && $this->start_time)
		{
			switch ($_type)
			{
				case 'sms':
					$T_T =
					[
						'name' => $this->displayname,
						'team' => $this->team_name,
						'time' => human::number(date("H:i"), $this->current_language),
					];
					$msg = T_(":name exited from :team at :time", $T_T);
					$msg .= "\n\n". 'tejarak.'.Tld. '/'. $this->team_short_name;

					break;

				default:
					$msg = $this->exit_message_telegram();
					break;
			}
		}
		return $msg;
	}


	/**
	 * exit message in telegram
	 *
	 * @return     string  ( description_of_the_return_value )
	 */
	public function exit_message_telegram()
	{
		$msg   = "💤 <b>". $this->displayname. "</b>\n";
		$start = $this->start_time;

		$start = strtotime($start);
		$total = floor(abs(strtotime('now') - $start) / 60);
		$pure  = (int) $total + (int) $this->plus - (int) $this->minus;

		if($pure < 0 )
		{
			$pure = 0;
		}

		$pure_human = human::time($pure, 'text', $this->current_language);

		$time_start = \lib\utility::date('H:i', $start , 'current');

		if($this->start_date && $this->start_date != date("Y-m-d"))
		{
			$start_date = $this->start_date;
			if($this->current_language == 'fa')
			{
				$start_date = \lib\utility\jdate::date("Y-m-d", strtotime($start_date));
			}
			$msg .="🌖 ". $start_date." ".  $time_start. "\n🌑 ". \lib\utility::date("Y-m-d H:i", time(), 'current'); //$time_now;
		}
		else
		{
			$msg .= $time_start. ' '. T_('until'). ' '. \lib\utility::date("H:i", time(), 'current'); //$time_now;
		}

		if($this->plus || $this->minus)
		{
			$msg        .= "\n🚩 ". human::number($total, $this->current_language);
		}

		if($this->minus)
		{
			$msg .= "\n➖ ". human::number($this->minus, $this->current_language);
		}

		$msg   .= "\n🕗 ". $pure_human;

		return $msg;
	}
}

?>