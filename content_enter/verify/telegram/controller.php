<?php
namespace content_enter\verify\telegram;


class controller extends \content_enter\main\controller
{
	public function _route()
	{
		// if step mobile is done
		// and step pass is done
		if(self::done_step('mobile') && self::done_step('pass'))
		{
			$this->get()->ALL('verify/telegram');
		}
		else
		{
			self::error_page('verify/telegram');
		}
	}
}
?>