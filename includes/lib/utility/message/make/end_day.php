<?php
namespace lib\utility\message\make;


trait end_day
{

	/**
	 * make end_day message
	 *
	 * @return     string  ( description_of_the_return_value )
	 */
	public function end_day()
	{
		if(\lib\db\teams::get_active_member($this->team_id))
		{
			return null;
		}

		$msg = null;
		$presence = \lib\db\hours::peresence($this->team_id);

		if(!empty($presence) && is_array($presence))
		{
			$show_time  = false;
			$show_gold  = false;
			$show_limit = -1;

			// if(isset($this->team_meta['report_settings']['telegram_group']) && $this->team_meta['report_settings']['telegram_group'])

			if(isset($this->team_meta['report_settings']['report_daily_time']) && $this->team_meta['report_settings']['report_daily_time'])
			{
				$show_time = true;
			}

			if(isset($this->team_meta['report_settings']['report_daily_gold']) && $this->team_meta['report_settings']['report_daily_gold'])
			{
				$show_gold = true;
			}


			if(isset($this->team_meta['report_settings']['report_count']))
			{
				$show_limit = intval($this->team_meta['report_settings']['report_count']);
			}

			$msg .= "#". T_('Report');
			// $msg .=  $this->team_name . " ";

			$msg  .= " ". \dash\date::fit_lang("l j F Y", time(), 'current'). "\n\n";
			$msg_admin  = $msg;

			$total_time = 0;
			$i          = 0;
			$count_show = 0;

			foreach ($presence as $name => $accepted)
			{
				if($show_limit === -1)
				{
					// no thing
				}
				elseif($show_limit === 0)
				{
					break;
				}
				else
				{
					if($show_limit <= $count_show)
					{
						break;
					}
				}

				$count_show++;

				$i += 1;
				$total_time += $accepted;
				$accepted = \dash\datetime::fit($accepted*60, 'humanTime');
				$accepted = \dash\utility\human::number($accepted, $this->current_language);
				$accepted = " <code>$accepted</code>";

				$accepted_time = null;
				if($show_time)
				{
					$accepted_time = $accepted;
				}

				$gold         = null;
				$gold1        = null;
				$gold2        = null;
				$gold3        = null;
				$default_gold = null;

				if($show_gold)
				{
					$gold         = "🏆 ";
					$gold1        = "🥇";
					$gold2        = "🥈";
					$gold3        = "🥉";
					$default_gold = "🏅 ";
				}

				switch ($i)
				{
					case 1:
						$msg .= $gold. T_($name). $gold1. $accepted_time;
						$msg_admin .= $gold. T_($name). $gold1. $accepted;
						break;

					case 2:
						$msg .= $gold. T_($name). $gold2. $accepted_time;
						$msg_admin .= $gold. T_($name). $gold2. $accepted;
						break;

					case 3:
						$msg .= $gold. T_($name). $gold3. $accepted_time;
						$msg_admin .= $gold. T_($name).$gold3. $accepted;
						break;

					default:
						$msg .= $default_gold. T_($name). $accepted_time;
						$msg_admin .= $default_gold. T_($name). $accepted;
						break;
				}
				$msg .= "\n";
				$msg_admin .= "\n";
			}
			$enterExit    = \dash\utility\human::number(\lib\db\hours::enter($this->team_id), $this->current_language);
			$countPersons = \dash\utility\human::number(count($presence), $this->current_language);
			// fill message of group

			$msg .= "👥 ". \dash\utility\human::number($countPersons, $this->current_language). "  ";

			if($enterExit != $countPersons)
			{
				$msg .= "🎭 ". \dash\utility\human::number($enterExit, $this->current_language) . "  ";
			}

			$msg .= "🕰 ". \dash\utility\human::number($total_time, $this->current_language);
			// fill message of admin

			$msg_admin .= "👥 ". $countPersons. "  ";

			if($enterExit != $countPersons)
			{
				$msg_admin .= "🎭 ". $enterExit . "  ";
			}
var_dump($msg_admin);
exit();
			$msg_admin .= "🕰 ". \dash\datetime::fit($total_time*60, 'humanTime', true);

		}
		return $msg;
	}
}

?>