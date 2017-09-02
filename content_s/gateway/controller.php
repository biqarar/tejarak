<?php
namespace content_s\gateway;

class controller extends \content_s\main\controller
{
	/**
	 * rout
	 */
	public function _route()
	{
		parent::_route();

		$url = \lib\router::get_url();

		$team_code = \lib\router::get_url(0);

		/**
		 * check team is exist
		 */
		if(!$this->model()->is_exist_team_code($team_code))
		{
			\lib\error::page();
		}

		$this->get(false, 'add')->ALL("/^([a-zA-Z0-9]+)\/gateway$/");
		$this->post('add')->ALL("/^([a-zA-Z0-9]+)\/gateway$/");

		$this->get(false, 'edit')->ALL("/^([a-zA-Z0-9]+)\/gateway\=([a-zA-Z0-9]+)$/");
		$this->post('edit')->ALL("/^([a-zA-Z0-9]+)\/gateway\=([a-zA-Z0-9]+)$/");

		$this->get(false, 'list')->ALL("/^([a-zA-Z0-9]+)\/gateway\/list$/");

		if(preg_match("/^([a-zA-Z0-9]+)\/gateway\/list$/", $url))
		{
			$this->display_name = 'content_s\gateway\dashboard.html';
		}

		// unroute url /a/gateway
		if($url === 'gateway')
		{
			\lib\error::page();
		}

		/**
		 * check if user not permission to load data
		 * redirect to show her report
		 * the user must be redirect to report page
		 */
		if(!\lib\storage::get_is_admin())
		{
			$this->redirector()->set_domain()->set_url('a/'.$team_code.'/report')->redirect();
			return;
		}
	}
}
?>