<?php
namespace content_a\getway;

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

		/**
		 * check team is exist
		 */
		if(!$this->model()->is_exist_team_code($team_code))
		{
			\lib\error::page();
		}

		$this->get(false, 'add')->ALL("/^([a-zA-Z0-9]+)\/getway$/");
		$this->post('add')->ALL("/^([a-zA-Z0-9]+)\/getway$/");

		$this->get(false, 'edit')->ALL("/^([a-zA-Z0-9]+)\/getway\=([a-zA-Z0-9]+)$/");
		$this->post('edit')->ALL("/^([a-zA-Z0-9]+)\/getway\=([a-zA-Z0-9]+)$/");

		$this->get(false, 'list')->ALL("/^([a-zA-Z0-9]+)(|\/([a-zA-Z0-9]+))$/");
		if(preg_match("/^([a-zA-Z0-9]+)(|\/(^getway)([a-zA-Z0-9]+))$/", $url))
		{
			$this->display_name = 'content_a\getway\dashboard.html';
		}

		// unroute url /a/getway
		if($url === 'getway')
		{
			\lib\error::page();
		}
		/**
		 * check if user not permission to load data
		 * redirect to show her report
		 */
		if(\lib\utility\shortURL::is($team_code))
		{
			$user_status = \lib\db\userteams::get(
				[
					'user_id' => $this->login('id'),
					'team_id' => \lib\utility\shortURL::decode($team_code),
					'limit'   => 1
				]
			);

			if(isset($user_status['rule']) && $user_status['rule'] === 'user')
			{
				$this->redirector()->set_domain()->set_url('a/'.$team_code.'/report/u')->redirect();
				return;
			}
		}
	}
}
?>