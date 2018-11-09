<?php
namespace lib\utility\message;


trait send
{
	/**
	 * Sends a message.
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	private function send_message()
	{
		if($this->status)
		{
			$this->must_send_to();

			$this->get_admin_bridge();

			if(!$this->status)
			{
				return false;
			}

			if(in_array('telegram', $this->send_by))
			{
				$this->send_by_telegram();
			}
		}
	}

	/**
	 * check sended date now to user
	 * if $_is_send is true save for this user as the user was resived the date now message
	 *
	 * @param      <type>   $_user_id  The user identifier
	 * @param      boolean  $_is_send  The is send
	 */
	public function sended_date_now_to_user($_user_id, $_is_send = false)
	{
		if(!$_is_send)
		{
			$get_log =
			[
				'user_id' => $_user_id,
				'caller'  => 'checkOneMessagePerDay',
				'code'    => date("Y-m-d"),
				'limit'   => 1,
			];
			$check_sended = \dash\db\logs::get($get_log);
			if($check_sended)
			{
				return true;
			}
			return false;
		}
		else
		{
			$insert =
			[
				'user_id' => $_user_id,
				'caller'  => 'checkOneMessagePerDay',
				'code'    => date("Y-m-d"),
			];
			return \dash\db\logs::insert($insert);
		}
	}


	/**
	 * Sends to yourself and parent.
	 *
	 * @param      <type>  $_message  The message
	 * @param      array   $_sort     The sort
	 */
	public function send_to_yourself_parent($_message, $_sort = [], $_send_sms = false, $_option = [])
	{
		$must_send_to = $this->must_send_to_user_data;
		if(!is_array($must_send_to))
		{
			return;
		}

		$must_send_to_user_id = array_column($must_send_to, 'id');
		$all_admin_user_id    = $this->all_admin_user_id;

		$not_admin            = array_diff($must_send_to_user_id, $all_admin_user_id);
		$not_admin            = array_unique($not_admin);

		$temp_not_admin = [];
		foreach ($must_send_to as $key => $value)
		{
			if(in_array($key, $not_admin))
			{
				$temp_not_admin[$key] = $value;
			}
		}
		$not_admin = $temp_not_admin;

		foreach ($not_admin as $user_id => $user_detail)
		{
			if(isset($user_detail['chatid']))
			{
				if(isset($_option['date_now']) && $_option['date_now'])
				{
					if(!$this->sended_date_now_to_user($user_id))
					{
						$this->sended_date_now_to_user($user_id, true);
						\lib\utility\telegram::sendMessage($user_detail['chatid'], $_message, ['sort' => 10]);
					}
				}
				else
				{
					\lib\utility\telegram::sendMessage($user_detail['chatid'], $_message, ['sort' => 10]);
				}
                unset($not_admin[$user_id]);
			}
		}

		if(in_array('sms', $this->send_by) && $_send_sms)
		{
			$temp          = $not_admin;
            unset($temp[$this->member_id]);

			$parent_mobile = array_column($temp, 'mobile');
			$parent_mobile = array_filter($parent_mobile);
			$parent_mobile = array_unique($parent_mobile);

			if(!empty($parent_mobile))
			{
				$sms_text = $_message;

				if(isset($_option['message_type']))
				{
					if(method_exists($this, $_option['message_type']))
					{
						$sms_text = $this->{$_option['message_type']}('sms');
					}
				}


				// minus price of sms
				$per_sms   = 15;
				$sms_len   = mb_strlen($sms_text);
				$count_sms = ceil($sms_len / 70);
				$price     = $count_sms * $per_sms * count($parent_mobile);

				if(isset($this->team_details['creator']))
				{
					// get user budget
					$user_budget = \dash\db\transactions::budget($this->team_details['creator'], ['unit' => 'toman']);

					// if($user_budget && is_array($user_budget))
					// {
					// 	$user_budget = array_sum($user_budget);
					// }

					if(intval($user_budget) >= $price)
					{
						$transaction_set =
				        [
							'caller'  => 'send:sms',
							'title'   => T_("Send sms"),
							'user_id' => $this->team_details['creator'],
							'minus'   => $price,
							'payment' => null,
							'verify'  => 1,
							'type'    => 'money',
							'unit'    => 'toman',
							'date'    => date("Y-m-d H:i:s"),
				        ];

				        \dash\db\transactions::set($transaction_set);

						// send sms
						\dash\utility\sms::send_array($parent_mobile, $sms_text, ['header' => false, 'footer' => false]);
					}
				}
			}
		}
	}


	/**
	 * Sends a by telegram.
	 */
	private function send_by_telegram()
	{
		if(!$this->status || !$this->message)
		{
			return false;
		}

		$admins_access_detail = $this->admins_access_detail;

		if(!$admins_access_detail)
		{
			return false;
		}

		// send message
		foreach ($this->message as $message_type => $message)
		{
			$first_msg = false;
			switch ($message_type)
			{
				// @example:
				// دوشنبه ۲۴ مهر ۱۳۹۶
				case 'date_now':
					// first msg in day
					if(\lib\utility\plan::access('telegram:first:of:day:date_now', $this->team_id))
					{
						foreach ($admins_access_detail as $key => $value)
						{
							// if no message sended to this user in this time send it
							// else not send this message
							if(!$this->sended_date_now_to_user($key))
							{
								$this->sended_date_now_to_user($key, true);
								\lib\utility\telegram::sendMessage($value['chat_id'], $message, ['sort' => 3]);
							}
						}
						$this->send_to_yourself_parent($message, ['sort' => 7], false, ['date_now' => true]);
					}
					break;

				// @example:
				// ✅ رضا محیطی
				case 'enter':
					if(\lib\utility\plan::access('telegram:enter:msg', $this->team_id))
					{
						foreach ($admins_access_detail as $key => $value)
						{
							if(isset($value['chat_id']) && isset($value['reportenterexit']) && $value['reportenterexit'])
							{
								\lib\utility\telegram::sendMessage($value['chat_id'], $message, ['sort' => 3]);
								$first_msg = true;
							}
						}
						$this->send_to_yourself_parent($message, ['sort' => 7], true, ['message_type' => $message_type]);
					}
					break;

				// @example:
				// دوشنبه ۲۴ مهر ۱۳۹۶
				// 💪 رضا محیطی
				// 🌖 🌱 👨‍💻 🥇
				case 'first_enter':
					// first msg in day
					if(\lib\utility\plan::access('telegram:first:of:day:msg', $this->team_id))
					{
						// check if this user is first login user
						if(\lib\db\hours::enter($this->team_id) <=1)
						{
							if(isset($this->team_meta['report_settings']['telegram_group']) && $this->team_meta['report_settings']['telegram_group'])
							{
								if(\lib\utility\plan::access('telegram:first:of:day:msg:group', $this->team_id))
								{
									\lib\utility\telegram::sendMessageGroup($this->team_group, $message, ['sort' => 4]);
								}
							}
						}
					}
					break;

				// @example:
				// 💤 رضا محیطی
				// ۰۸:۲۸ تا ۱۷:۴۹
				// 🕗 ۹ ساعت و ۲۱ دقیقه
				case 'exit_message':
					if(\lib\utility\plan::access('telegram:exit:msg', $this->team_id))
					{
						// check if this user is first login user
						$is_first_transaction = \lib\db\hours::enter($this->team_id);
						$is_first_transaction = ($is_first_transaction <= 1) ? true : false;

						foreach ($admins_access_detail as $key => $value)
						{
							if(isset($value['chat_id']) && isset($value['reportenterexit']) && $value['reportenterexit'])
							{
								\lib\utility\telegram::sendMessage($value['chat_id'], $message, ['sort' => 2]);
							}
						}

						$this->send_to_yourself_parent($message, ['sort' => 7], true, ['message_type' => $message_type]);
					}
					break;

				// @example:
				// #گزارش دوشنبه ۲۴ مهر ۱۳۹۶
				// 🏆 رضا محیطی🥇 ۹:۲۱
				// 🏆 جواد عوض‌زاده🥈 ۸:۳۸
				// 🏆 احمد کریمی🥉 ۱:۳۶
				// 👥 ۳  🕰 ۱۱۷۵
				case 'end_day':
					if(\lib\utility\plan::access('telegram:end:day:report', $this->team_id))
					{
						$live = \lib\db\hours::live($this->team_id);
						if(intval($live) <= 0 )
						{
							if(isset($this->team_meta['report_settings']['telegram_group']) && $this->team_meta['report_settings']['telegram_group'])
							{
								if(isset($this->team_meta['report_settings']['report_daily']) && $this->team_meta['report_settings']['report_daily'])
								{
									if(\lib\utility\plan::access('telegram:end:day:report:group', $this->team_id))
									{
										\lib\utility\telegram::sendMessageGroup($this->team_group, $message, ['sort' => 4]);
									}
								}
							}

							foreach ($admins_access_detail as $key => $value)
							{
								if(isset($value['chat_id']) && isset($value['reportdaily']) && $value['reportdaily'])
								{
									\lib\utility\telegram::sendMessage($value['chat_id'], $message, ['sort' => 3]);
								}
							}
						}
					}
					break;

				default:
					// every other message
					// if have the group send in group
					// if have admin send to admin
					if(isset($this->team_group) && $this->team_group)
					{
						if(\lib\utility\plan::access('telegram:first:of:day:msg:group', $this->team_id))
						{
							\lib\utility\telegram::sendMessageGroup($this->team_group, $message, ['sort' => 4]);
						}
					}

					foreach ($this->admins_access_detail as $key => $value)
					{
						\lib\utility\telegram::sendMessage($value['chat_id'], $message, ['sort' => 1]);
					}

					break;
			}

		}
		// send message by sorting
		\lib\utility\telegram::sort_send();
		\lib\utility\telegram::clean_cash();
	}
}
?>