<?php
namespace content_enter\verify\telegram;


class controller extends \content_enter\main\controller
{
	public function _route()
	{
		$this->get()->ALL('verify/telegram');
	}
}
?>