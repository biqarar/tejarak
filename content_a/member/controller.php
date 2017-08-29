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

		$team_code = \lib\router::get_url(0);

		unset($_SESSION['first_go_to_setup']);

		/**
		 * check team is exist
		 */
		if(!$this->model()->is_exist_team_code($team_code))
		{
			\lib\error::page();
		}

		$this->get(false, 'add')->ALL("/^([a-zA-Z0-9]+)\/member$/");
		$this->post('add')->ALL("/^([a-zA-Z0-9]+)\/member$/");

		$this->get(false, 'edit')->ALL("/^([a-zA-Z0-9]+)\/member\=([a-zA-Z0-9]+)$/");
		$this->post('edit')->ALL("/^([a-zA-Z0-9]+)\/member\=([a-zA-Z0-9]+)$/");

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