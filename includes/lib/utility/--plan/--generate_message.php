<?php
namespace lib\utility\plan;
use \lib\utility;
use \lib\utility\human;
use \lib\debug;
use \lib\db;

trait generate_message
{

	/**
	 * generate msg
	 *
	 * @param      <type>  $_type  The type
	 *
	 * @return     string  ( description_of_the_return_value )
	 */
	public static function generate_telegram_message($_type = null)
	{
		$current_language = \lib\define::get_language();
		// self::$my_name = trim("*". self::$my_name. "*", "*");

		$msg = null;
		$msg_admin = null;
		switch ($_type)
		{


			case 'enter':
				$msg = "✅ ". self::$my_name;
				// $msg .= " | ". self::$my_team_name;
				if(self::$my_plus)
				{
					$msg .= "\n➕ ". human::number(self::$my_plus, $current_language);
				}
				break;

			case 'exit':
				$msg   = "💤 <b>". self::$my_name. "</b>\n";
				$start = self::$my_start_time;
				$start = strtotime($start);
				$total = floor(abs(strtotime('now') - $start) / 60);
				$pure  = (int) $total + (int) self::$my_plus - (int) self::$my_minus;

				if($pure < 0 )
				{
					$pure = 0;
				}

				$pure_human = human::time($pure, 'text', $current_language);

				$time_start = \lib\utility::date('H:i', $start , 'current');

				if(isset(self::$_args['start']['date']) && self::$_args['start']['date'] != date("Y-m-d"))
				{
					$start_date = self::$_args['start']['date'];
					if($current_language == 'fa')
					{
						$start_date = \lib\utility\jdate::date("Y-m-d", strtotime($start_date));
					}
					$msg .="🌖 ". $start_date." ".  $time_start. "\n🌑 ". \lib\utility::date("Y-m-d H:i", time(), 'current'); //$time_now;
				}
				else
				{
					$msg .= $time_start. ' '. T_('until'). ' '. \lib\utility::date("H:i", time(), 'current'); //$time_now;
				}



				if(self::$my_plus || self::$my_minus)
				{
					$msg        .= "\n🚩 ". human::number($total, $current_language);
				}
				if(self::$my_minus)
				{
					$msg .= "\n➖ ". human::number(self::$my_minus, $current_language);
				}
				$msg        .= "\n🕗 ". $pure_human;
				break;

			case 'date_now':
				$msg = \lib\utility::date('l j F Y', time() , 'current');
				break;

			case 'first_enter':
				// if this person is first one in this day send current date
				// add minus and plus if exist
				// create custom message for group
				$msg = \lib\utility::date('l j F Y', time() , 'current');

				// $msg .= "\n". "🙋‍♂ ". self::$my_name;
				$msg .= "\n";
				// check group settings to send first member name
				if(
					isset(self::$my_report_settings['telegram_group']) &&
					isset(self::$my_report_settings['first_member_name']) &&
					self::$my_report_settings['telegram_group'] &&
					self::$my_report_settings['first_member_name']
				  )
				{
					$msg .= "💪 ". self::$my_name;
					$msg .= "\n"."🌖 🌱 👨‍💻 🥇";
				}

				break;

			case 'report_end_day':
			case 'report_end_day_admin':
				// if the team have active member
				// never make the end report day message
				if(\lib\db\teams::get_active_member(self::$my_team_id))
				{
					break;
				}

				$presence = \lib\db\hours::peresence(self::$my_team_id);

				if(!empty($presence) && is_array($presence))
				{
					$show_time  = false;
					$show_gold  = false;
					$show_limit = -1;
					if(isset(self::$my_report_settings['telegram_group']) && self::$my_report_settings['telegram_group'])
					{
						if(isset(self::$my_report_settings['report_daily_time']) && self::$my_report_settings['report_daily_time'])
						{
							$show_time = true;
						}

						if(isset(self::$my_report_settings['report_daily_gold']) && self::$my_report_settings['report_daily_gold'])
						{
							$show_gold = true;
						}


						if(isset(self::$my_report_settings['report_count']))
						{
							$show_limit = intval(self::$my_report_settings['report_count']);
						}
					}

					$msg .= "#". T_('Report');
					// $msg .=  self::$my_team_name . " ";

					$msg  .= " ". \lib\utility::date("l j F Y", time(), 'current'). "\n\n";
					$msg_admin  .= $msg;

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
						$accepted = human::time($accepted, 'number', 'current');
						$accepted = human::number($accepted, $current_language);
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
					$enterExit    = human::number(\lib\db\hours::enter(self::$my_team_id), $current_language);
					$countPersons = human::number(count($presence), $current_language);
					// fill message of group

					$msg .= "👥 ". human::number($countPersons, $current_language). "  ";

					if($enterExit != $countPersons)
					{
						$msg .= "🎭 ". human::number($enterExit, $current_language) . "  ";
					}

					$msg .= "🕰 ". human::number($total_time, $current_language);
					// fill message of admin

					$msg_admin .= "👥 ". $countPersons. "  ";

					if($enterExit != $countPersons)
					{
						$msg_admin .= "🎭 ". $enterExit . "  ";
					}

					$msg_admin .= "🕰 ". human::number(human::time($total_time, 'text', 'current'), $current_language);

				}

				if($_type === 'report_end_day_admin')
				{
					$msg = $msg_admin;
				}

				break;

			default:
				break;
		}

		if($msg)
		{
			$msg = self::$my_team_report_header. "\n".  $msg. "\n". self::$my_team_report_footer;
		}

		return $msg;
	}
}
?>