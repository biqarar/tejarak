<?php
namespace content_a\home;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{
		parent::_route();

		$url = \lib\router::get_url();


		// if user_setup is null redirect to setup page
		// The user is the first time he uses the system,
		// so we will transfer him to the installation file
		// But before that we check that this user is not registered in any team.
		if(!$this->login('setup'))
		{
			$this->redirector()->set_domain()->set_url('a/setup')->redirect();
			return;
		}

		$this->get(false, 'dashboard')->ALL();
		// route url like this /a/ermile
		if(preg_match("/^([a-zA-Z0-9]+)$/", $url))
		{
			if($this->model()->is_exist_team($url))
			{
				\lib\router::set_controller("content_a\\team\\controller");
				return;
			}
		}

		// route url like this /a/2kf
		if(preg_match("/^([a-zA-Z0-9]+)$/", $url, $split))
		{
			if(isset($split[1]))
			{
				$id = \lib\utility\shortURL::decode($split[1]);
				if($id && $this->model()->is_exist_team_id($id))
				{
					\lib\router::set_controller("content_a\\member\\controller");
				}
			}
		}

		/**
		 * route report urls
		 * in url must be find .../report/... | .../report
		 */
		if(preg_match("/(\/report\/)|(\/report$)/", $url))
		{
			\lib\router::set_controller("content_a\\report\\controller");
			return;
		}
	}
}
?>