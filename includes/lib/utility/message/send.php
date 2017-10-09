<?php
namespace lib\utility\message;
use \lib\utility;
use \lib\utility\human;
use \lib\debug;
use \lib\db;
use \lib\utility\telegram;
use \lib\utility\plan;

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
	 * Sends to yourself and parent.
	 *
	 * @param      <type>  $_message  The message
	 * @param      array   $_sort     The sort
	 */
	public function send_to_yourself_parent($_message, $_sort = [], $_send_sms = false)
	{
		$must_send_to = $this->must_send_to_user_data;
		if(is_array($must_send_to))
		{
			$must_send_to_user_id = array_column($must_send_to, 'id');
			$all_admin_user_id = $this->all_admin_user_id;

			$not_admin = array_diff($must_send_to_user_id, $all_admin_user_id);
			$not_admin = array_unique($not_admin);

			foreach ($not_admin as $key => $user_id)
			{
				if(array_key_exists($user_id, $must_send_to))
				{
					if(intval($this->member_id) === intval($user_id))
					{

					}
					else
					{
						if(in_array('sms', $this->send_by) && $_send_sms)
						{
							$temp          = $must_send_to;
                            unset($temp[$this->member_id]);
							$parent_mobile = array_column($temp, 'mobile');
							$parent_mobile = array_filter($parent_mobile);
							$parent_mobile = array_unique($parent_mobile);

							// send sms
							// \lib\utility\sms::send_array($parent_mobile, $_message);

							// minus price of sms
							$per_sms       = 15;
							$sms_len       = mb_strlen($_message);
							$count_sms     = ceil($sms_len / 70);
							$price         = $count_sms * $per_sms * count($parent_mobile);

							if(isset($this->team_details['creator']))
							{
								// get user budget
								$user_budget = \lib\db\transactions::budget($this->team_details['creator'], ['unit' => 'toman']);

								if($user_budget && is_array($user_budget))
								{
									$user_budget = array_sum($user_budget);
								}

								if(intval($user_budget) >= $price)
								{
									$transaction_set =
							        [
										'caller'          => 'send:sms',
										'title'           => T_("Send sms"),
										'user_id'         => $this->team_details['creator'],
										'minus'           => $price,
										'payment'         => null,
										// 'related_foreign' => 'teams',
										// 'related_id'      => $this->team_id,
										'verify'          => 1,
										'type'            => 'money',
										'unit'            => 'toman',
										'date'            => date("Y-m-d H:i:s"),
										// 'invoice_id'      => $invoice_id,
							        ];

							        \lib\db\transactions::set($transaction_set);
								}
							}
						}
					}

					if(isset($must_send_to[$user_id]['chatid']))
					{
						telegram::sendMessage($must_send_to[$user_id]['chatid'], $_message, ['sort' => 10]);
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

		// foreach ($this->message as $key => $message)
		// {
		// 	if(isset($this->team_group) && $this->team_group)
		// 	{
		// 		if(plan::access('telegram:first:of:day:msg:group', $this->team_id))
		// 		{
		// 			telegram::sendMessageGroup($this->team_group, $message, ['sort' => 4]);
		// 		}
		// 	}
		// 	foreach ($admins_access_detail as $k => $value)
		// 	{
		// 		telegram::sendMessage($value['chat_id'], $message, ['sort' => 1]);
		// 	}
		// }
		//


		foreach ($this->message as $message_type => $message)
		{
			$first_msg = false;
			switch ($message_type)
			{
				case 'enter':

					if(plan::access('telegram:enter:msg', $this->team_id))
					{
						foreach ($admins_access_detail as $key => $value)
						{
							if(isset($value['chat_id']) && isset($value['reportenterexit']) && $value['reportenterexit'])
							{
								telegram::sendMessage($value['chat_id'], $message, ['sort' => 3]);
								$first_msg = true;
							}
						}
						$this->send_to_yourself_parent($message, ['sort' => 7], true);
					}
					break;

				case 'first_enter':
					// first msg in day
					if(plan::access('telegram:first:of:day:msg', $this->team_id))
					{
						// check if this user is first login user
						if(\lib\db\hours::enter($this->team_id) <=1)
						{
							if(isset($this->team_meta['my_report_settings']['telegram_group']) && $this->team_meta['my_report_settings']['telegram_group'])
							{
								if(plan::access('telegram:first:of:day:msg:group', $this->team_id))
								{
									telegram::sendMessageGroup($this->team_group, $message, ['sort' => 4]);
								}
							}

							foreach ($admins_access_detail as $key => $value)
							{
								if(isset($value['chat_id']) && isset($value['reportenterexit']) && $value['reportenterexit'])
								{
									if(!$first_msg)
									{
										telegram::sendMessage($value['chat_id'], $message, ['sort' => 3]);
									}

									telegram::sendMessage($value['chat_id'], $this->date_now(), ['sort' => 1]);
								}
							}
							$this->send_to_yourself_parent($this->date_now());
							$this->send_to_yourself_parent($message, ['sort' => 7], true);

						}
					}
					break;

				case 'exit_message':
					if(plan::access('telegram:exit:msg', $this->team_id))
					{
						// check if this user is first login user
						$is_first_transaction = \lib\db\hours::enter($this->team_id);
						$is_first_transaction = ($is_first_transaction <= 1) ? true : false;

						if($is_first_transaction)
						{
							if(isset($this->team_meta['my_report_settings']['telegram_group']) && $this->team_meta['my_report_settings']['telegram_group'])
							{
								if(plan::access('telegram:first:of:day:msg:group', $this->team_id))
								{
									telegram::sendMessageGroup($this->team_group, $this->date_now(), ['sort' => 1]);
								}
							}
						}

						foreach ($admins_access_detail as $key => $value)
						{
							if(isset($value['chat_id']) && isset($value['reportenterexit']) && $value['reportenterexit'])
							{
								if($is_first_transaction)
								{
									telegram::sendMessage($value['chat_id'], $this->date_now(), ['sort' => 1]);
								}
								telegram::sendMessage($value['chat_id'], $message, ['sort' => 2]);
							}
						}
						$this->send_to_yourself_parent($this->date_now());
						$this->send_to_yourself_parent($message, ['sort' => 7], true);
					}
					break;

				case 'end_day':
					if(plan::access('telegram:end:day:report', $this->team_id))
					{
						if(\lib\db\hours::live($this->team_id) <= 0 )
						{
							if(isset($this->team_meta['my_report_settings']['telegram_group']) && $this->team_meta['my_report_settings']['telegram_group'])
							{
								if(isset($this->team_meta['my_report_settings']['report_daily']) && $this->team_meta['my_report_settings']['report_daily'])
								{
									if(plan::access('telegram:end:day:report:group', $this->team_id))
									{
										telegram::sendMessageGroup($this->team_group, $message, ['sort' => 4]);
									}
								}
							}

							foreach ($admins_access_detail as $key => $value)
							{
								if(isset($value['chat_id']) && isset($value['reportdaily']) && $value['reportdaily'])
								{
									telegram::sendMessage($value['chat_id'], $message, ['sort' => 3]);
								}
							}
							$this->send_to_yourself_parent($message, ['sort' => 7], true);

						}
					}
					break;

				default:
					// every other message
					// if have the group send in group
					// if have admin send to admin
					if(isset($this->team_group) && $this->team_group)
					{
						if(plan::access('telegram:first:of:day:msg:group', $this->team_id))
						{
							telegram::sendMessageGroup($this->team_group, $message, ['sort' => 4]);
						}
					}

					foreach ($this->admins_access_detail as $key => $value)
					{
						telegram::sendMessage($value['chat_id'], $message, ['sort' => 1]);
					}

					break;
			}

			// send message by sorting
			telegram::sort_send();
			telegram::clean_cash();
		}

	}
}
?>