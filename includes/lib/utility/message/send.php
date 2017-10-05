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
			$this->get_admins();

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
			switch ($message_type)
			{
				case 'enter':
					$first_msg = false;

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