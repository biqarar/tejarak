<?php
namespace lib\utility\plan;
use \lib\utility;
use \lib\utility\human;
use \lib\debug;
use \lib\db;

trait feature
{
	public static $name       = null;
	public static $start_time = null;
	public static $plus       = 0;
	public static $minus      = 0;


	public static function check_feature($_args)
	{
		$check = true;
		if(!array_key_exists('type', $_args)) $check = false;
		if(!isset($_args['args']['userteam_details']['team_id'])) $check = false;
		if(!$check)
		{
			// return false;
		}

		if(isset($_args['inserted_record']['plus']))
		{
			self::$plus = $_args['inserted_record']['plus'];
		}

		if(isset($_args['start']['start']))
		{
			self::$start_time = $_args['start']['start'];
		}

		if(isset($_args['args']['userteam_details']['displayname']))
		{
			self::$name = $_args['args']['userteam_details']['displayname'];
		}

		if(isset($_args['args']['minus']))
		{
			self::$minus = $_args['args']['minus'];
		}

		$team_id = $_args['args']['userteam_details']['team_id'];

		$team_detail = \lib\db\teams::get_by_id($team_id);

		$group_id = null;
		if(isset($team_detail['telegram_id']) && $team_detail['telegram_id'])
		{
			$group_id = $team_detail['telegram_id'];
		}

		// get admins of team
		$admins = \lib\db\userteams::get(['team_id' => $team_id, 'rule' => 'admin']);
		if(!$admins || !is_array($admins))
		{
			return false;
		}

		$admins_telegram_id = array_column($admins, 'telegram_id');
		$admins_telegram_id = array_filter($admins_telegram_id);
		$admins_telegram_id = array_unique($admins_telegram_id);

		if(empty($admins_telegram_id))
		{
			$admins_id = array_column($admins, 'id');
			if(!empty($admins_id))
			{
				$admins_id = implode(',', $admins_id);
				$chat_id = "SELECT users.user_chat_id AS `chat_id` FROM users WHERE users.id IN($admins_id) ";
				$chat_id = \lib\db::get($chat_id, 'chat_id');
				if(!empty($chat_id))
				{
					$admins_telegram_id = $chat_id;
				}
			}
		}
		if($group_id)
		{
			array_push($admins_telegram_id, $group_id);
		}

		$admins_telegram_id = array_filter($admins_telegram_id);
		$admins_telegram_id = array_unique($admins_telegram_id);

		if(empty($admins_telegram_id))
		{
			return false;
		}

		switch ($_args['type'])
		{
			case 'enter':
				if(\lib\utility\plan::access('telegram:enter:msg', $team_id))
				{
					foreach ($admins_telegram_id as $key => $chat_id)
					{
						\lib\utility\telegram::sendMessage($chat_id, self::generate_msg('enter'));
					}
				}
				break;

			case 'exit':
				if(\lib\utility\plan::access('telegram:exit:msg', $team_id))
				{
					foreach ($admins_telegram_id as $key => $chat_id)
					{
						\lib\utility\telegram::sendMessage($chat_id, self::generate_msg('exit'));
					}
				}
				break;
			default:
				# code...
				break;
		}
	}


	public static function generate_msg($_type = null)
	{
		$msg = null;
		switch ($_type)
		{
			case 'enter':
				// if this person is first one in this day send current date
				// add minus and plus if exist

				// if(\lib\db\staff::enter() <= 1)
				// {
				// 	$tg = self::send_telegram($date_now);
				// 	// create custom message for group
				// 	$msg_start = $date_now;
				// 	if(self::$user_id === 11)
				// 	{
				// 		$msg_start .= "\n". "🙋‍♂ $name";
				// 	}
				// 	else
				// 	{
				// 		$msg_start .= "\n". "💪 $name";
				// 	}
				// 	$msg_start .= "\n"."🇮🇷 🌖 🌱 👨‍💻 🥇";
				// 	$msg_start .= "\n". "#سختـکوشـباشیم";

				// 	// send message for group
				// 	if(\lib\router::get_root_domain('domain') !== 'germile')
				// 	{
				// 		$tg_final = self::send_telegram($msg_start, 'group');
				// 	}
				// }
				$msg = "✅ ". self::$name;
				if(self::$plus)
				{
					$msg .= "\n➕ ". human::number(self::$plus, 'fa');
				}
				break;


			case 'exit':
				$msg   = "💤 ". self::$name. "\n";
				$start = self::$start_time;
				$start = strtotime( date('Y/m/d'). ' '. $start);
				$total = floor(abs(strtotime('now') - $start) / 60);

				if($total < 5)
				{
					// exit from switch and show message
					$msg = "🚷 $msg";
				}

				// if more than one day!
				// if($plus > 1440)
				// {
				// 	$plus = 1440;
				// }
				$pure       =  (int) $total + (int) self::$plus - (int) self::$minus;
				if($pure < 0 )
				{
					$pure = 0;
				}
				$pure_human = human::time($pure, 'text' ,'fa');
				$time_start = \lib\utility::date('H:i', $start , 'default');

				$msg        .= $time_start. ' '. T_('to'). ' '. \lib\utility::date("H:i", time(), 'default'); //$time_now;

				if(self::$plus || self::$minus)
				{
					$msg        .= "\n🚩 ". human::number($total, 'fa');
				}
				if(self::$minus)
				{
					$msg .= "\n➖ ". human::number(self::$minus, 'fa');
				}
				$msg        .= "\n🕗 ". $pure_human;

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
				// 		foreach ($presence as $name => $accepted)
				// 		{
				// 			$i += 1;
				// 			$total_time += $accepted;
				// 			$accepted = human::time($accepted, 'number', 'fa');
				// 			switch ($i)
				// 			{
				// 				case 1:
				// 					$msg_final .= "🏆". " ". T_($name)."🥇";
				// 					$msg_admin .= "🏆". " ". T_($name)."🥇". " `". $accepted. "`";
				// 					break;

				// 				case 2:
				// 					$msg_final .= "🏆". " ". T_($name)."🥈";
				// 					$msg_admin .= "🏆". " ". T_($name)."🥈". " `". $accepted. "`";
				// 					break;

				// 				case 3:
				// 					$msg_final .= "🏆". " ". T_($name)."🥉";
				// 					$msg_admin .= "🏆". " ". T_($name)."🥉". " `". $accepted. "`";
				// 					break;

				// 				default:
				// 					$msg_final .= "🏅". " ". T_($name);
				// 					$msg_admin .= "🏅". " ". T_($name). " `". $accepted. "`";
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