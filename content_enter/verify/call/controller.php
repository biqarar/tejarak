<?php
namespace content_enter\verify\call;


class controller extends \content_enter\main\controller
{
	public function _route()
	{
		// if this step is locked go to error page and return
		if(self::lock('verify/call'))
		{
			self::error_page('verify/call');
			return;
		}

		// check method
		if(self::get_request_method() === 'get')
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
				// send code way
				self::send_code_way();
			}
		}
		elseif(self::get_request_method() === 'post')
		{
			$this->post('verify')->ALL('verify/call');
		}
		else
		{
			self::error_method('verify/call');
		}

	}
}
?>