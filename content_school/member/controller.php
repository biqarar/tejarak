<?php
namespace content_school\member;

class controller extends \content_school\main\controller
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

		$this->get(false, 'list')->ALL("/^([a-zA-Z0-9]+)\/teacher$/");
		$this->post('list')->ALL("/^([a-zA-Z0-9]+)\/teacher$/");

		$this->get(false, 'list')->ALL("/^([a-zA-Z0-9]+)\/student$/");
		$this->post('list')->ALL("/^([a-zA-Z0-9]+)\/student$/");


		$this->get(false, 'add')->ALL("/^([a-zA-Z0-9]+)\/teacher\/add$/");
		$this->post('add')->ALL("/^([a-zA-Z0-9]+)\/teacher\/add$/");


		$this->get(false, 'add')->ALL("/^([a-zA-Z0-9]+)\/student\/add$/");
		$this->post('add')->ALL("/^([a-zA-Z0-9]+)\/student\/add$/");

		if(preg_match("/^([a-zA-Z0-9]+)\/student$/", $url) || preg_match("/^([a-zA-Z0-9]+)\/teacher$/", $url))
		{
			$this->display_name = 'content_school\member\dashboard.html';
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
			$this->redirector()->set_domain()->set_url('school/'.$team_code.'/report')->redirect();
			return;
		}

	}
}
?>