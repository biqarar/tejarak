<?php
namespace lib\utility\message;


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

			if(isset($this->team_details['name']))
			{
				$this->team_name = $this->team_details['name'];
			}

			if(isset($this->team_details['shortname']))
			{
				$this->team_short_name = $this->team_details['shortname'];
			}

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
	private function must_send_to()
	{
		if($this->status && $this->team_id)
		{
			// get admins of team
			$this->admins_detail = $admins_detail = \lib\db\userteams::get(['team_id' => $this->team_id, 'rule' => 'admin']);

			$must_send_to = [];

			$all_admin_user_id       = [];
			$this->all_admin_user_id = [];

			if(is_array($admins_detail) && !empty($admins_detail))
			{
				$must_send_to = array_merge($must_send_to, array_column($admins_detail, 'user_id'));

				$this->all_admin_user_id = $must_send_to;
			}

			if($this->member_id)
			{
				$must_send_to[] = $this->member_id;
			}

			if($this->send_parent && $this->member_id)
			{
				$get_parent = \lib\db\userparents::get(['user_id' => $this->member_id, 'status' => 'enable', 'related_id' => $this->team_id]);
				if(is_array($get_parent))
				{
					$must_send_to = array_merge($must_send_to, array_column($get_parent, 'parent'));
				}
			}

			$must_send_to = array_filter($must_send_to);
			$must_send_to = array_unique($must_send_to);

			if(!empty($must_send_to))
			{
				$in = implode(',' , $must_send_to);
				$must_send_to_user_data = \lib\db\users::get(['id' => ["IN", "($in)"]]);
				if(is_array($must_send_to_user_data))
				{
					$key                           = array_column($must_send_to_user_data, 'id');
					$must_send_to_user_data       = array_combine($key, $must_send_to_user_data);
					$this->must_send_to_user_data = $must_send_to_user_data;
				}
			}
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

			if(in_array('sms', $this->send_by))
			{
				// get admins mobile
				$this->admin_mobile();
			}
		}
	}


	/**
	 * get admins mobile
	 */
	public function admin_mobile()
	{
		$must_send_to_user_data = $this->must_send_to_user_data;
		if(is_array($must_send_to_user_data))
		{
			$mobiles = array_column($must_send_to_user_data, 'mobile');
			$mobiles = array_filter($mobiles);
			$mobiles = array_unique($mobiles);
			$this->all_sended_mobile = $mobiles;
		}
	}


	/**
	 * find admin telegram chat id
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function admin_telegram_chat_id()
	{
		$admins_detail    = $this->admins_detail;

		if(!$admins_detail || !is_array($admins_detail))
		{
			$this->status = false;
			return;
		}

		$this->admins_access_detail = [];

		$chat_id = array_column($this->must_send_to_user_data, 'chatid');
		$chat_id = array_combine(array_keys($this->must_send_to_user_data), $chat_id);

		if(!empty($chat_id))
		{
			$admins_detail_telegram_id = array_unique($chat_id);
			$admins_detail_telegram_id = array_filter($admins_detail_telegram_id);
		}

		$admins_access_detail = [];

		foreach ($admins_detail as $key => $value)
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

				if(is_array($chat_id) && array_key_exists($value['user_id'], $chat_id))
				{
					$admins_access_detail[$value['user_id']]['chat_id'] = $chat_id[$value['user_id']];
				}
			}
		}

		$this->admins_access_detail = $admins_access_detail;


		$admins_detail_telegram_id = array_filter($admins_detail_telegram_id);
		$admins_detail_telegram_id = array_unique($admins_detail_telegram_id);

		if(!$this->admins_access_detail)
		{
			$this->status = false;
		}

	}
}
?>