<?php
namespace content_a\setting\telegram;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{

		parent::_route();

		$url = \lib\router::get_url();

		if($url === 'setting/telegram')
		{
			\lib\error::page();
		}
		$this->get(false, 'telegram')->ALL("/.*/");
		$this->post('telegram')->ALL("/.*/");

	}
}
?>