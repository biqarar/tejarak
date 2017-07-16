<?php
namespace lib\utility\plan;
use \lib\utility;
use \lib\utility\human;
use \lib\debug;
use \lib\db;
use \lib\utility\telegram;
use \lib\utility\plan;

trait feature
{
	public static $my_name               = null;
	public static $my_start_time         = null;
	public static $my_group_id           = null;
	public static $my_plus               = 0;
	public static $my_minus              = 0;
	public static $my_team_id            = null;
	public static $my_admins             = null;
	public static $my_admins_id          = null;
	public static $my_admins_telegram_id = null;
	public static $_args                 = [];
	public static $my_team_detail        = [];
	public static $my_team_name          = null;
	public static $my_team_name_hashtag  = null;
	public static $admins_access_detail  = [];
	public static $my_team_report_header = null;
	public static $my_team_report_footer = null;
	public static $my_report_settings    = [];


	// 'telegram_group'    => string 'on' (length=2)
	// 'start_time_first'  => string 'on' (length=2)
	// 'first_member_name' => string 'on' (length=2)
	// 'report_daily'      => string 'on' (length=2)
	// 'report_daily_time' => string 'on' (length=2)
	// 'report_daily_gold' => string 'on' (length=2)
	// 'report_count'      => string '-1' (length=2)


	/**
	 * check some date
	 * when this var is false
	 * means we can not run the feature
	 * return false
	 *
	 * @var        boolean
	 */
	public static $check_is_true = true;

	/**
	 * check feacher
	 *
	 * @param      <type>   $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function check_feature($_args)
	{
		self::$_args = $_args;
		if(!isset($_args['args']['userteam_details']['team_id'])) return false;

		self::$my_team_id = $_args['args']['userteam_details']['team_id'];

		switch ($_args['type'])
		{
			case 'enter':

				$config_is_run = false;
				if(plan::access('telegram:enter:msg', self::$my_team_id))
				{
					self::config();

					$config_is_run = true;

					if(!self::$check_is_true)
					{
						return false;
					}

					foreach (self::$admins_access_detail as $key => $value)
					{
						if(isset($value['chat_id']) && isset($value['reportenterexit']) && $value['reportenterexit'])
						{
							telegram::sendMessage($value['chat_id'], self::generate_telegram_message('enter'), ['sort' => 3]);
						}
					}
				}

				// first msg in day
				if(plan::access('telegram:first:of:day:msg', self::$my_team_id))
				{
					if(!$config_is_run)
					{
						self::config();
					}
					// check if this user is first login user
					if(\lib\db\hours::enter(self::$my_team_id) <=1)
					{
						if(isset(self::$my_report_settings['telegram_group']) && self::$my_report_settings['telegram_group'])
						{
							telegram::sendMessageGroup(self::$my_group_id, self::generate_telegram_message('first_enter'), ['sort' => 4]);
						}

						foreach (self::$admins_access_detail as $key => $value)
						{
							if(isset($value['chat_id']) && isset($value['reportenterexit']) && $value['reportenterexit'])
							{
								telegram::sendMessage($value['chat_id'], self::generate_telegram_message('first_enter'), ['sort' => 3]);
								telegram::sendMessage($value['chat_id'], self::generate_telegram_message('date_now'), ['sort' => 1]);
							}
						}
					}
				}
				// send message by sorting
				telegram::sort_send();
				telegram::clean_cash();

				break;

			case 'exit':

				$config_is_run = false;
				if(plan::access('telegram:exit:msg', self::$my_team_id))
				{
					self::config();

					$config_is_run = true;

					if(!self::$check_is_true)
					{
						return false;
					}

					foreach (self::$admins_access_detail as $key => $value)
					{
						if(isset($value['chat_id']) && isset($value['reportenterexit']) && $value['reportenterexit'])
						{
							telegram::sendMessage($value['chat_id'], self::generate_telegram_message('exit'), ['sort' => 1]);
						}
					}
				}

				if(plan::access('telegram:end:day:report', self::$my_team_id))
				{
					if(!$config_is_run)
					{
						self::config();
					}

					if(\lib\db\hours::live(self::$my_team_id) <= 0 )
					{
						if(isset(self::$my_report_settings['telegram_group']) && self::$my_report_settings['telegram_group'])
						{
							if(isset(self::$my_report_settings['report_daily']) && self::$my_report_settings['report_daily'])
							{
								telegram::sendMessageGroup(self::$my_group_id, self::generate_telegram_message('report_end_day'), ['sort' => 3]);
							}
						}

						foreach (self::$admins_access_detail as $key => $value)
						{
							if(isset($value['chat_id']) && isset($value['reportdaily']) && $value['reportdaily'])
							{
								telegram::sendMessage($value['chat_id'], self::generate_telegram_message('report_end_day_admin'), ['sort' => 2]);
							}
						}
					}
				}
				// send message by sorting
				telegram::sort_send();
				telegram::clean_cash();

				break;
			default:
				# code...
				break;
		}
	}

}
?>