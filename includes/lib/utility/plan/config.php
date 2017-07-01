<?php
namespace lib\utility\plan;
use \lib\utility;
use \lib\utility\human;
use \lib\debug;
use \lib\db;

trait config
{
	public static function config()
	{
		$check = true;
		if(!array_key_exists('type', self::$_args)) $check = false;
		if(!isset(self::$_args['args']['userteam_details']['team_id'])) $check = false;
		if(!$check)
		{
			self::$check_is_true = false;
			return false;
		}

		if(isset(self::$_args['inserted_record']['plus']))
		{
			self::$my_plus = self::$_args['inserted_record']['plus'];
		}

		if(isset(self::$_args['start']['date']))
		{
			self::$my_start_time = self::$_args['start']['date'];
		}

		if(isset(self::$_args['start']['start']))
		{
			self::$my_start_time .= ' '. self::$_args['start']['start'];
		}

		if(isset(self::$_args['args']['userteam_details']['displayname']))
		{
			self::$my_name = self::$_args['args']['userteam_details']['displayname'];
		}

		if(isset(self::$_args['args']['minus']))
		{
			self::$my_minus = self::$_args['args']['minus'];
		}

		self::$my_team_id = self::$_args['args']['userteam_details']['team_id'];

		self::$my_team_detail = \lib\db\teams::get_by_id(self::$my_team_id);

		self::$my_group_id = null;
		if(isset(self::$my_team_detail['telegram_id']) && self::$my_team_detail['telegram_id'])
		{
			self::$my_group_id = self::$my_team_detail['telegram_id'];
		}

		// get admins of team
		self::$my_admins = \lib\db\userteams::get(['team_id' => self::$my_team_id, 'rule' => 'admin']);
		if(!self::$my_admins || !is_array(self::$my_admins))
		{
			self::$check_is_true = false;
			return false;
		}

		self::$my_admins_telegram_id = array_column(self::$my_admins, 'telegram_id');
		self::$my_admins_telegram_id = array_filter(self::$my_admins_telegram_id);
		self::$my_admins_telegram_id = array_unique(self::$my_admins_telegram_id);

		if(empty(self::$my_admins_telegram_id))
		{
			self::$my_admins_id = array_column(self::$my_admins, 'user_id');
			if(!empty(self::$my_admins_id))
			{
				self::$my_admins_id = implode(',', self::$my_admins_id);
				$ids = self::$my_admins_id;
				$chat_id = "SELECT users.user_chat_id AS `chat_id` FROM users WHERE users.id IN($ids) ";
				$chat_id = \lib\db::get($chat_id, 'chat_id');
				if(!empty($chat_id))
				{
					self::$my_admins_telegram_id = $chat_id;
				}
			}
		}

		self::$my_admins_telegram_id = array_filter(self::$my_admins_telegram_id);
		self::$my_admins_telegram_id = array_unique(self::$my_admins_telegram_id);

		if(empty(self::$my_admins_telegram_id))
		{
			self::$check_is_true = false;
			return false;
		}
	}
}
?>