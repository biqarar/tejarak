<?php
namespace lib\utility\message;
use \lib\utility;
use \lib\utility\human;
use \lib\debug;
use \lib\db;

trait ready
{
	/**
	 * { function_description }
	 * load admins telegram id
	 * load admins mobile number
	 * load team details for get
	 * 		header
	 * 		footer
	 * 		group id
	 * 		...
	 * load user team details of this admin to check
	 * 		is this admin is active
	 * 		is this admin have chat id
	 * 		is for this admin set send report
	 *
	 *
	 * @param      <type>  $_team_id  The team identifier
	 */
	private function ready()
	{
		if($this->team_id && $this->status)
		{
			$this->team_details = \lib\db\teams::get_by_id($this->team_id);

			$this->report_setting();
		}
	}

	/**
	 * load team meta and find report setting
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	private function report_setting()
	{

		// get the report header
		if(isset($this->team_details['reportheader']))
		{
			$this->report_header = $this->team_details['reportheader'];
		}

		// get the report footer
		if(isset($this->team_details['reportfooter']))
		{
			$this->report_footer = $this->team_details['reportfooter'];
		}

		if(isset($this->team_details['telegram_id']) && $this->team_details['telegram_id'])
		{
			$this->team_group = $this->team_details['telegram_id'];
		}

		if(isset($this->team_details['meta']))
		{
			$meta = [];
			if(is_string($this->team_details['meta']) && substr($this->team_details['meta'], 0,1) === '{')
			{
				$meta = json_decode($this->team_details['meta'], true);
			}
			elseif(is_array($this->team_details['meta']))
			{
				$meta = $this->team_details['meta'];
			}

			$this->team_meta = $meta;

			if(!empty($meta) && isset($meta['report_settings']) && is_array($meta['report_settings']))
			{
				$this->report_setting = $meta['report_settings'];
			}
		}
	}

	/**
	 * Gets the admins.
	 * get the admins details
	 */
	private function get_admins()
	{
		if($this->status && $this->team_id)
		{
			// get admins of team
			$this->admins_detail = \lib\db\userteams::get(['team_id' => $this->team_id, 'rule' => 'admin']);
		}
	}


	/**
	 * Gets the admin bridge.
	 * the the admins bridge by check send by
	 * if send by telegram the admins need the telegram id
	 * if send by sms the amdins need mobile
	 */
	public function get_admin_bridge()
	{
		if($this->status && $this->team_id && $this->send_by)
		{
			if(in_array('telegram', $this->send_by))
			{
				// find admins chat id
				$this->admin_telegram_chat_id();
			}
		}
	}


	/**
	 * find admin telegram chat id
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function admin_telegram_chat_id()
	{
		if(!$this->admins_detail || !is_array($this->admins_detail))
		{
			$this->status = false;
			return;
		}

		$this->admins_access_detail = [];

		// get the admins telegram id
		$this->admins_detail_telegram_id = array_column($this->admins_detail, 'telegram_id');
		$this->admins_detail_telegram_id = array_filter($this->admins_detail_telegram_id);
		$this->admins_detail_telegram_id = array_unique($this->admins_detail_telegram_id);

		if(empty($this->admins_detail_telegram_id))
		{
			$this->admins_detail_id = array_column($this->admins_detail, 'user_id');
			$chat_id = null;

			if($this->admins_detail_id && is_array($this->admins_detail_id))
			{
				if($this->member_id)
				{
					$this->admins_detail_id[] = $this->member_id;
				}

				$this->admins_detail_id = array_unique($this->admins_detail_id);

				$this->admins_detail_id = implode(',', $this->admins_detail_id);
				$ids = $this->admins_detail_id;
				$chat_id = "SELECT users.id AS `id`, users.chatid AS `chat_id` FROM users WHERE users.id IN($ids) ";
				$chat_id = \lib\db::get($chat_id, ['id', 'chat_id']);

				if(!empty($chat_id))
				{
					$this->admins_detail_telegram_id = array_unique($chat_id);
				}
			}

			$admins_access_detail = [];
			foreach ($this->admins_detail as $key => $value)
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

					if(is_array($chat_id))
					{
						if(array_key_exists($value['user_id'], $chat_id))
						{
							if(intval($this->member_id) === intval($value['user_id']))
							{
								$admins_access_detail[$value['user_id']]['reportdaily']     = 1;
								$admins_access_detail[$value['user_id']]['reportenterexit'] = 1;
							}

							$admins_access_detail[$value['user_id']]['chat_id'] = $chat_id[$value['user_id']];
						}
					}
				}
			}

			$this->admins_access_detail = $admins_access_detail;
		}

		$this->admins_detail_telegram_id = array_filter($this->admins_detail_telegram_id);
		$this->admins_detail_telegram_id = array_unique($this->admins_detail_telegram_id);

		if(!$this->admins_access_detail)
		{
			$this->status = false;
		}

	}
}
?>