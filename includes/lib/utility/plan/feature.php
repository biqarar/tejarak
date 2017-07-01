<?php
namespace lib\utility\plan;
use \lib\utility;
use \lib\utility\human;
use \lib\debug;
use \lib\db;

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
				if(\lib\utility\plan::access('telegram:enter:msg', self::$my_team_id))
				{
					self::config();

					$config_is_run = true;

					if(!self::$check_is_true)
					{
						return false;
					}

					foreach (self::$my_admins_telegram_id as $key => $chat_id)
					{
						\lib\utility\telegram::sendMessage($chat_id, self::generate_telegram_message('enter'));
					}
				}
				// first msg in day
				if(\lib\utility\plan::access('telegram:first:of:day:msg', self::$my_team_id))
				{
					if(!$config_is_run)
					{
						self::config();
					}

					if(\lib\db\hours::enter(self::$my_team_id) <=1)
					{
						\lib\utility\telegram::sendMessageGroup(self::$my_group_id, self::generate_telegram_message('first_enter'));

						foreach (self::$my_admins_telegram_id as $key => $chat_id)
						{
							\lib\utility\telegram::sendMessage($chat_id, self::generate_telegram_message('date_now'));
							// \lib\utility\telegram::sendMessage($chat_id, self::generate_telegram_message('first_enter'));
						}
					}
				}
				break;

			case 'exit':

				$config_is_run = false;
				if(\lib\utility\plan::access('telegram:exit:msg', self::$my_team_id))
				{
					self::config();

					$config_is_run = true;

					if(!self::$check_is_true)
					{
						return false;
					}

					foreach (self::$my_admins_telegram_id as $key => $chat_id)
					{
						\lib\utility\telegram::sendMessage($chat_id, self::generate_telegram_message('exit'));
					}
				}

				if(\lib\utility\plan::access('telegram:end:day:report', self::$my_team_id))
				{
					if(!$config_is_run)
					{
						self::config();
					}

					if(\lib\db\hours::live(self::$my_team_id) <= 0 )
					{
						\lib\utility\telegram::sendMessageGroup(self::$my_group_id, self::generate_telegram_message('report_end_day'));

						foreach (self::$my_admins_telegram_id as $key => $chat_id)
						{
							\lib\utility\telegram::sendMessage($chat_id, self::generate_telegram_message('report_end_day_admin'));
						}


					}
				}

				break;
			default:
				# code...
				break;
		}
	}

}
?>