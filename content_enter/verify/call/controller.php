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

		// if the user is login redirect to base
		parent::if_login_not_route();

		// check remeber me is set
		// if remeber me is set: login!
		parent::check_remeber_me();

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
				$way = self::send_way();
				if($way)
				{
					// open lock of next step to route it
					self::next_step('verify/'. $way);
					// go to next way of send code
					self::go_to($way);
					return;
				}
				else
				{
					// open lock from what
					self::next_step('verify/what');
					self::go_to('what');
				}
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