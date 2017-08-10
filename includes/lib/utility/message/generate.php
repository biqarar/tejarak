<?php
namespace lib\utility\message;
use \lib\utility;
use \lib\utility\human;
use \lib\debug;
use \lib\db;

trait generate
{
	/**
	 * generate message by message type
	 * if the function by message type is exist
	 * run this
	 * on that function
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	private function generate_message()
	{
		if($this->status)
		{
			if($this->message_type)
			{
				if(method_exists($this, $this->message_type))
				{
					$this->{$this->message_type}();
				}
			}
			else
			{
				$this->status = false;
			}
		}
	}
}
?>