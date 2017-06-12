<?php
namespace content_enter\verify\call;


class controller extends \content_enter\main\controller
{
	public function _route()
	{
		// if step mobile is done
		// and step pass is done
		if(self::done_step('mobile') && self::done_step('pass'))
		{
			// if the user start my bot and wa have her chat id
			// if user start my bot try to send code to this use
			// if okay route this
			// else go to nex way
			if($this->model()->send_call_code())
			{
				$this->get()->ALL('verify/call');
			}
			else
			{
				$way = self::send_way();
				if($way)
				{
					// go to next way of send code
					self::go_to($way);
					return;
				}
				else
				{
					self::go_to('what');
				}
			}
		}
		else
		{
			self::error_page('verify/call');
		}
	}
}
?>