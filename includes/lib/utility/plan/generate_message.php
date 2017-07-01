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
				if(self::$my_plus)
				{
					$msg .= "\n➕ ". human::number(self::$my_plus, \lib\define::get_language());
				}
				break;

			case 'exit':
				$msg   = "💤 ". self::$my_name. "\n";
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

				$msg .= "\n"."🇮🇷 🌖 🌱 👨‍💻 🥇";
				// $msg .= "\n". "#سختـکوشـباشیم";
				break;

			case 'report_end_day':
				// if this person is first one in this day send current date
				// if(\lib\db\staff::live() <= 0)
				// {
				// 	$presence = \lib\db\staff::peresence();
				// 	if(!empty($presence) && is_array($presence))
				// 	{
				// 		// $msg_final .= "#". T_('Report'). " ";
				// 		$msg_final  .= "#گزارش ";
				// 		$msg_final  .= "$date_now\n\n";
				// 		$msg_admin  .= $msg_final;
				// 		$total_time = 0;
				// 		$i          = 0;
				// 		foreach ($presence as $my_name => $accepted)
				// 		{
				// 			$i += 1;
				// 			$total_time += $accepted;
				// 			$accepted = human::time($accepted, 'number', 'fa');
				// 			switch ($i)
				// 			{
				// 				case 1:
				// 					$msg_final .= "🏆". " ". T_($my_name)."🥇";
				// 					$msg_admin .= "🏆". " ". T_($my_name)."🥇". " `". $accepted. "`";
				// 					break;

				// 				case 2:
				// 					$msg_final .= "🏆". " ". T_($my_name)."🥈";
				// 					$msg_admin .= "🏆". " ". T_($my_name)."🥈". " `". $accepted. "`";
				// 					break;

				// 				case 3:
				// 					$msg_final .= "🏆". " ". T_($my_name)."🥉";
				// 					$msg_admin .= "🏆". " ". T_($my_name)."🥉". " `". $accepted. "`";
				// 					break;

				// 				default:
				// 					$msg_final .= "🏅". " ". T_($my_name);
				// 					$msg_admin .= "🏅". " ". T_($my_name). " `". $accepted. "`";
				// 					break;
				// 			}
				// 			$msg_final .= "\n";
				// 			$msg_admin .= "\n";
				// 		}
				// 		$enterExit    = human::number(\lib\db\staff::enter(), 'fa');
				// 		$countPersons = human::number(count($presence), 'fa');
				// 		// fill message of group
				// 		$msg_final  .= "#سختـکوشـباشیم". "\n";
				// 		$msg_final .= "🎭". $enterExit . "  ";
				// 		$msg_final .= "👥". $countPersons. "  ";
				// 		$msg_final .= "🕰". $total_time;
				// 		// fill message of admin
				// 		$msg_admin  .= "#سختـکوشـباشیم". "\n";
				// 		$msg_admin .= "🎭". $enterExit . "  ";
				// 		$msg_admin .= "👥". $countPersons. "  ";
				// 		$msg_admin .= "🕰". human::time($total_time, 'number', 'fa');
				// 		// if we have less than 3person in day, dont send message
				// 		if(count($presence) < 3)
				// 		{
				// 			$send_report = false;
				// 		}
				// 	}
				// }
				break;

			default:
				break;
		}
		return $msg;
	}
}
?>