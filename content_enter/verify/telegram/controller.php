<?php
namespace content_enter\verify\telegram;


class controller extends \content_enter\main\controller
{
	public function _route()
	{
		// if this step is locked go to error page and return
		if(self::lock('verify/telegram'))
		{
			self::error_page('verify/telegram');
			return;
		}

		// if the user is login redirect to base
		parent::if_login_not_route();

		// check remeber me is set
		// if remeber me is set: login!
		parent::check_remeber_me();

		if(self::get_request_method() === 'get')
		{
			// if the user start my bot and wa have her chat id
			// if user start my bot try to send code to this use
			// if okay route this
			// else go to nex way
			if($this->model()->send_telegram_code())
			{
				$this->get()->ALL('verify/telegram');
			}
			else
			{
				$way = self::send_way();
				if($way)
				{
					// open lock to load this page
					self::next_step('verify/'. $way);
					// go to next way of send code
					self::go_to($way);
					return;
				}
				else
				{
					// open lock to load this page
					self::next_step('verify/what');
					self::go_to('what');
				}
			}
		}
		elseif(self::get_request_method() === 'post')
		{
			$this->post('verify')->ALL('verify/telegram');
		}
		else
		{
			self::error_method('verify/telegram');
		}
	}
}
?>