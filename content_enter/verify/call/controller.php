<?php
namespace content_enter\verify\call;


class controller extends \content_enter\main\controller
{
	public function _route()
	{
		$this->get()->ALL('verify/call');
	}
}
?>