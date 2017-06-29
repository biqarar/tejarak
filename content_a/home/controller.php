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
		if($this->login('id') && !$this->login('setup'))
		{
			if(!\lib\db\userteams::get(['user_id' => $this->login('id'), 'status' => 'active', 'limit' => 1]))
			{
				$this->redirector()->set_domain()->set_url('a/setup')->redirect();
				return;
			}
			else
			{
				$_SESSION['user']['setup'] = 1;
			}
		}

		// check if the user is gateway redirect to hours page
		if(!$this->login('mobile') && $this->login('parent') && $this->login('username') && $this->login('pass'))
		{
			$check_is_gateway = \lib\db\userteams::get(['user_id' => $this->login('id'), 'rule' => 'gateway', 'limit'=> 1]);
			if(isset($check_is_gateway['team_id']))
			{
				$shortname = \lib\db\teams::get_by_id($check_is_gateway['team_id']);
				if(isset($shortname['shortname']))
				{

					$this->redirector($this->view()->url->base. '/'. $shortname['shortname'])->redirect();
					return;
				}
			}

		}

		// list of all team the user is them
		$this->get(false, 'dashboard')->ALL();

		// route url like this /a/2kf
		if(preg_match("/^([a-zA-Z0-9]+)\/edit$/", $url))
		{
			\lib\router::set_controller("content_a\\team\\controller");
			return;
		}

		// route url like this /a/2kf
		if(preg_match("/^([a-zA-Z0-9]+)$/", $url))
		{
			\lib\router::set_controller("content_a\\member\\controller");
			return;
		}

		// route url like this /a/2kf/member
		if(preg_match("/^([a-zA-Z0-9]+)\/member(|\=[a-zA-Z0-9]+)$/", $url))
		{
			\lib\router::set_controller("content_a\\member\\controller");
			return;
		}

		// route url like this /a/2kf/plan
		if(preg_match("/^([a-zA-Z0-9]+)\/plan$/", $url))
		{
			\lib\router::set_controller("content_a\\plan\\controller");
			return;
		}

		// route url like this /a/2kf/gateway
		if(preg_match("/^([a-zA-Z0-9]+)\/gateway(|\/list)$/", $url))
		{
			\lib\router::set_controller("content_a\\gateway\\controller");
			return;
		}

		// route url like this /a/2kf/gateway
		if(preg_match("/^([a-zA-Z0-9]+)\/gateway(|\=[a-zA-Z0-9]+)$/", $url))
		{
			\lib\router::set_controller("content_a\\gateway\\controller");
			return;
		}

		/**
		 * route report urls
		 * in url must be find .../report/... | .../report
		 */
		if(preg_match("/(\/report\/)|(\/report$)/", $url))
		{
			\lib\storage::set_team_code_url(\lib\router::get_url(0));
			\lib\router::set_controller("content_a\\report\\controller");
			return;
		}
	}
}
?>