<?php
namespace content_a\member;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	public function _route()
	{
		parent::_route();

		$url = \lib\router::get_url();


		$this->get(false, 'add')->ALL("/^team\/([a-zA-Z0-9]+)\/member$/");
		$this->post('add')->ALL("/^team\/([a-zA-Z0-9]+)\/member$/");


		$this->get(false, 'edit')->ALL("/^team\/([a-zA-Z0-9]+)\/member\=([a-zA-Z0-9]+)$/");
		$this->post('edit')->ALL("/^team\/([a-zA-Z0-9]+)\/member\=([a-zA-Z0-9]+)$/");

		// $this->get(false, 'add')->ALL("/^team\/([a-zA-Z0-9]+)\/branch=([a-zA-Z0-9]+)\/member$/");
		// $this->post('add')->ALL("/^team\/([a-zA-Z0-9]+)\/branch=([a-zA-Z0-9]+)\/member$/");


		$this->get(false, 'list')->ALL("/^([a-zA-Z0-9]+)(|\/([a-zA-Z0-9]+))$/");
		if(preg_match("/^([a-zA-Z0-9]+)(|\/(^member)([a-zA-Z0-9]+))$/", $url))
		{
			$this->display_name = 'content_a\member\dashboard.html';
		}

		// unroute url /a/member
		if($url === 'member')
		{
			\lib\error::page();
		}
	}
}
?>