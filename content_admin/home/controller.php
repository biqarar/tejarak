<?php
namespace content_admin\home;

class controller extends \content_admin\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{
		parent::_route();

		$url = \lib\router::get_url();

		$url = explode('/', $url);


		// if user_setup is null redirect to setup page
		if(!$this->login('setup'))
		{
			$this->redirector()->set_domain()->set_url('admin/setup')->redirect();
			return;
		}

	}
}
?>