<?php
namespace lib\utility\message;

trait check_plan
{
	/**
	 * generate message by message type
	 * if the function by message type is exist
	 * run this
	 * on that function
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	private function check_plan()
	{
		if($this->status)
		{
			if($this->type)
			{
				if(method_exists($this, $this->type))
				{
					$msg = $this->{$this->type}();
					if($msg)
					{
						if(Tld === 'dev')
						{
							$msg .= "\n #Dev";
						}
					}
					$this->message[] = $msg;
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