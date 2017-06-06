<?php
namespace content_admin\member;

class controller extends \content_admin\main\controller
{
	/**
	 * rout
	 */
	public function _route()
	{
		parent::_route();

		$url = \lib\router::get_url();

		// route url like this /admin/team/ermile/member
		$this->get(false, 'add')->ALL("/^team\/([a-zA-Z0-9]+)\/member$/");
		$this->post('add')->ALL("/^team\/([a-zA-Z0-9]+)\/member$/");

		// route url like this /admin/team/ermile/branch=sarshomar/member
		$this->get(false, 'add')->ALL("/^team\/([a-zA-Z0-9]+)\/branch=([a-zA-Z0-9]+)\/member$/");
		$this->post('add')->ALL("/^team\/([a-zA-Z0-9]+)\/branch=([a-zA-Z0-9]+)\/member$/");

		// route url like this /admin/ermile/sarshomar
		$this->get(false, 'list')->ALL("/^([a-zA-Z0-9]+)\/([a-zA-Z0-9]+)$/");
		if(preg_match("/^([a-zA-Z0-9]+)\/([a-zA-Z0-9]+)$/", $url))
		{
			$this->display_name = 'content_admin\member\dashboard.html';
		}

		// unroute url /admin/member
		if($url === 'member')
		{
			\lib\error::page();
		}
	}
}
?>