<?php
namespace lib\utility\message;
use \lib\utility;
use \lib\utility\human;
use \lib\debug;
use \lib\db;
use \lib\utility\telegram;

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
			switch ($this->send_by)
			{
				case 'telegram':
					$this->send_by_telegram();
					break;

				default:
					$this->status = false;
					break;
			}
		}
	}


	/**
	 * Sends a by telegram.
	 */
	private function send_by_telegram()
	{
		if($this->status && $this->message)
		{
			if(!empty($this->admins_access_detail))
			{
				foreach ($this->message as $message)
				{
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
				}
			}
			telegram::sort_send();
			telegram::clean_cash();
		}
	}
}
?>