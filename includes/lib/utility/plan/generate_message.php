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
		// self::$my_name = trim("*". self::$my_name. "*", "*");

		$msg = null;
		switch ($_type)
		{
			case 'enter':
				$msg = "✅ ". self::$my_name;
				$msg .= " ". self::$my_team_name_hashtag;
				if(self::$my_plus)
				{
					$msg .= "\n➕ ". human::number(self::$my_plus, \lib\define::get_language());
				}
				break;

			case 'exit':
				$msg   = "💤 ". self::$my_name;
				$msg .= " ". self::$my_team_name_hashtag. "\n";
				$start = self::$my_start_time;
				$start = strtotime($start);
				$total = floor(abs(strtotime('now') - $start) / 60);
				$pure  = (int) $total + (int) self::$my_plus - (int) self::$my_minus;

				if($pure < 0 )
				{
					$pure = 0;
				}

				$pure_human = human::time($pure, 'text', \lib\define::get_language());

				$time_start = \lib\utility::date('H:i', $start , 'current');

				$msg        .= $time_start. ' '. T_('to'). ' '. \lib\utility::date("H:i", time(), 'current'); //$time_now;

				if(self::$my_plus || self::$my_minus)
				{
					$msg        .= "\n🚩 ". human::number($total, \lib\define::get_language());
				}
				if(self::$my_minus)
				{
					$msg .= "\n➖ ". human::number(self::$my_minus, \lib\define::get_language());
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
				$msg .= "\n". "💪 ". self::$my_name;
				$msg .= " ". self::$my_team_name_hashtag;

				$msg .= "\n"."🌖 🌱 👨‍💻 🥇";
				// $msg .= "\n". "#سختـکوشـباشیم";
				break;

			case 'report_end_day':
			case 'report_end_day_admin':
				$presence = \lib\db\hours::peresence(self::$my_team_id);
				if(!empty($presence) && is_array($presence))
				{
					$msg_admin = '';
					$msg .= "#". T_('Report'). " \n";
					$msg .= self::$my_team_name_hashtag . " ";

					// $msg  .= "#گزارش ";
					$msg  .= \lib\utility::date("l j F Y", time(), 'current'). "\n\n";
					$msg_admin  .= $msg;
					$total_time = 0;
					$i          = 0;
					foreach ($presence as $name => $accepted)
					{
						$i += 1;
						$total_time += $accepted;
						$accepted = human::time($accepted, 'number', 'fa');
						switch ($i)
						{
							case 1:
								$msg .= "🏆". " ". T_($name)."🥇";
								$msg_admin .= "🏆". " ". T_($name)."🥇". " `". $accepted. "`";
								break;

							case 2:
								$msg .= "🏆". " ". T_($name)."🥈";
								$msg_admin .= "🏆". " ". T_($name)."🥈". " `". $accepted. "`";
								break;

							case 3:
								$msg .= "🏆". " ". T_($name)."🥉";
								$msg_admin .= "🏆". " ". T_($name)."🥉". " `". $accepted. "`";
								break;

							default:
								$msg .= "🏅". " ". T_($name);
								$msg_admin .= "🏅". " ". T_($name). " `". $accepted. "`";
								break;
						}
						$msg .= "\n";
						$msg_admin .= "\n";
					}
					$enterExit    = human::number(\lib\db\hours::enter(self::$my_team_id), \lib\define::get_language());
					$countPersons = human::number(count($presence), \lib\define::get_language());
					// fill message of group
					// $msg  .= "#سختـکوشـباشیم". "\n";
					$msg .= "🎭". $enterExit . "  ";
					$msg .= "👥". $countPersons. "  ";
					$msg .= "🕰". $total_time;
					// fill message of admin
					// $msg_admin  .= "#سختـکوشـباشیم". "\n";
					$msg_admin .= "🎭". $enterExit . "  ";
					$msg_admin .= "👥". $countPersons. "  ";
					$msg_admin .= "🕰". human::time($total_time, 'number', \lib\define::get_language());
					// if we have less than 3person in day, dont send message
					if(count($presence) < 3)
					{
						$send_report = false;
					}
				}

				if($_type === 'report_end_day_admin')
				{
					$msg = $msg_admin;
				}

				break;

			default:
				break;
		}
		// $msg = '<html>'. $msg. '</html>';
		return $msg;
	}
}
?>