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
		// check some things and turn of the swich
		$check = true;
		if(!array_key_exists('type', self::$_args)) $check = false;
		if(!isset(self::$_args['args']['userteam_details']['team_id'])) $check = false;
		if(!$check)
		{
			self::$check_is_true = false;
			return false;
		}
		// get the user plus time he save
		if(isset(self::$_args['inserted_record']['plus']))
		{
			self::$my_plus = self::$_args['inserted_record']['plus'];
		}
		// get the minus of hours record
		if(isset(self::$_args['args']['minus']))
		{
			self::$my_minus = self::$_args['args']['minus'];
		}
		// get the start date of hours record
		if(isset(self::$_args['start']['date']))
		{
			self::$my_start_time = self::$_args['start']['date'];
		}
		// get the start time of hours record
		if(isset(self::$_args['start']['start']))
		{
			self::$my_start_time .= ' '. self::$_args['start']['start'];
		}
		// get the user display name
		if(isset(self::$_args['args']['userteam_details']['displayname']))
		{
			self::$my_name = self::$_args['args']['userteam_details']['displayname'];
		}
		// get the team id
		self::$my_team_id = self::$_args['args']['userteam_details']['team_id'];
		// load team details
		self::$my_team_detail = \lib\db\teams::get_by_id(self::$my_team_id);

		// get the report header
		if(isset(self::$my_team_detail['reportheader']))
		{
			self::$my_team_report_header = self::$my_team_detail['reportheader'];
		}

		// get the report footer
		if(isset(self::$my_team_detail['reportfooter']))
		{
			self::$my_team_report_footer = self::$my_team_detail['reportfooter'];
		}
		// get the report settings from meta
		$report_settings = [];

		if(isset(self::$my_team_detail['meta']) && is_string(self::$my_team_detail['meta']) && substr(self::$my_team_detail['meta'], 0,1) === '{')
		{
			$meta = json_decode(self::$my_team_detail['meta'], true);
			if(isset($meta['report_settings']))
			{
				$report_settings = $meta['report_settings'];
			}
		}

		self::$my_report_settings = $report_settings;

		// get the team name
		if(isset(self::$my_team_detail['name']))
		{
			self::$my_team_name = self::$my_team_detail['name'];
			self::$my_team_name_hashtag = "#". str_replace(' ', '_', self::$my_team_name);
		}
		// get the team group id
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
		// get the admins telegram id
		self::$my_admins_telegram_id = array_column(self::$my_admins, 'telegram_id');
		self::$my_admins_telegram_id = array_filter(self::$my_admins_telegram_id);
		self::$my_admins_telegram_id = array_unique(self::$my_admins_telegram_id);

		if(empty(self::$my_admins_telegram_id))
		{
			self::$my_admins_id = array_column(self::$my_admins, 'user_id');
			$chat_id = null;
			if(!empty(self::$my_admins_id))
			{
				self::$my_admins_id = implode(',', self::$my_admins_id);
				$ids = self::$my_admins_id;
				$chat_id = "SELECT users.id AS `id`, users.chatid AS `chat_id` FROM users WHERE users.id IN($ids) ";
				$chat_id = \lib\db::get($chat_id, ['id', 'chat_id']);

				if(!empty($chat_id))
				{
					self::$my_admins_telegram_id = $chat_id;
				}
			}

			$admins_access_detail = [];
			foreach (self::$my_admins as $key => $value)
			{
				if(isset($value['user_id']))
				{
					if(array_key_exists('reportdaily', $value))
					{
						$admins_access_detail[$value['user_id']]['reportdaily'] = $value['reportdaily'];
					}

					if(array_key_exists('reportenterexit', $value))
					{
						$admins_access_detail[$value['user_id']]['reportenterexit'] = $value['reportenterexit'];
					}

					if(array_key_exists($value['user_id'], $chat_id))
					{
						$admins_access_detail[$value['user_id']]['chat_id'] = $chat_id[$value['user_id']];
					}
				}
			}

			self::$admins_access_detail = $admins_access_detail;
		}

		self::$my_admins_telegram_id = array_filter(self::$my_admins_telegram_id);
		self::$my_admins_telegram_id = array_unique(self::$my_admins_telegram_id);

		if(empty(self::$admins_access_detail))
		{
			self::$check_is_true = false;
			return false;
		}
	}
}
?>