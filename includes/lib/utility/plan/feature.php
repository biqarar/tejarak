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
	public static $my_plus               = 0;
	public static $my_minus              = 0;
	public static $my_team_id            = null;
	public static $my_admins             = null;
	public static $my_admins_id          = null;
	public static $my_admins_telegram_id = null;
	public static $_args                 = [];
	public static $my_team_detail        = [];
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
				if(\lib\utility\plan::access('telegram:enter:msg', self::$my_team_id))
				{
					self::config();

					if(!self::$check_is_true)
					{
						return false;
					}

					foreach (self::$my_admins_telegram_id as $key => $chat_id)
					{
						\lib\utility\telegram::sendMessage($chat_id, self::generate_telegram_message('enter'));
					}
				}
				break;

			case 'exit':
				if(\lib\utility\plan::access('telegram:exit:msg', self::$my_team_id))
				{
					self::config();

					if(!self::$check_is_true)
					{
						return false;
					}

					foreach (self::$my_admins_telegram_id as $key => $chat_id)
					{
						\lib\utility\telegram::sendMessage($chat_id, self::generate_telegram_message('exit'));
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