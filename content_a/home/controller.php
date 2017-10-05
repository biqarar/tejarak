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
		// if setup is null redirect to setup page
		// The user is the first time he uses the system,
		// so we will transfer him to the installation file
		// But before that we check that this user is not registered in any team.
		if($this->login('id') && !$this->login('setup'))
		{
			// if  the user is login and first login
			// we set the setup field of user on 1
			$_SESSION['user']['setup'] = '1';
			\lib\db\users::update(['setup' => 1], $this->login('id'));

			if(!\lib\db\userteams::get(['user_id' => $this->login('id'), 'status' => 'active', 'limit' => 1]))
			{
				$this->redirector()->set_domain()->set_url('a/setup')->redirect();
				return;
			}
		}

		// check if the user is gateway redirect to hours page
		if(!$this->login('mobile') && $this->login('parent') && $this->login('username') && $this->login('password'))
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

		$team_id = \lib\router::get_url(0);
		$rule = 'user';
		$is_creator = false;
		if(\lib\utility\shortURL::is($team_id))
		{
			$team_id = \lib\utility\shortURL::decode($team_id);
			if($team_id && $this->login('id'))
			{
				$team_details = \lib\db\teams::get_by_id($team_id);

				if(isset($team_details['creator']) && intval($team_details['creator']) === intval($this->login('id')))
				{
					\lib\temp::set('is_creator', true);
					$is_creator = true;
				}
				else
				{
					\lib\temp::set('is_creator', false);
				}

				$load_userteam_record = \lib\db\userteams::get(['team_id' => $team_id, 'user_id' => $this->login('id'), 'limit' => 1]);
				if(isset($load_userteam_record['rule']))
				{
					$rule = $load_userteam_record['rule'];
				}
			}
		}
		// set if user is admin to route some module
		$is_admin = false;
		switch ($rule)
		{
			case 'admin':
				$is_admin = true;
				\lib\temp::set('is_admin', true);
				break;

			default:
				\lib\temp::set('is_admin', false);
				break;
		}

		// route url like this /a/2kf
		if(preg_match("/^([a-zA-Z0-9]+)$/", $url))
		{
			\lib\router::set_controller("content_a\\dashboard\\controller");
			return;
		}

		// route url like this /a/2kf
		if(preg_match("/^([a-zA-Z0-9]+)\/edit$/", $url))
		{
			if($is_admin)
			{
				\lib\router::set_controller("content_a\\team\\controller");
				return;
			}
			else
			{
				\lib\error::access();
			}
		}

		// route url like this /a/2kf/member
		if(preg_match("/^([a-zA-Z0-9]+)\/member(|\/add|\=[a-zA-Z0-9]+)$/", $url))
		{
			if($is_admin)
			{
				\lib\router::set_controller("content_a\\member\\controller");
				return;
			}
			else
			{
				\lib\error::access();
			}
		}

		// route url like this /a/2kf/plan
		if(preg_match("/^([a-zA-Z0-9]+)\/plan$/", $url))
		{
			if($is_admin)
			{
				\lib\router::set_controller("content_a\\plan\\controller");
				return;
			}
			else
			{
				\lib\error::access();
			}
		}

		// route url like this /a/2kf/gateway
		if(preg_match("/^([a-zA-Z0-9]+)\/gateway(|\/list)$/", $url))
		{
			if($is_admin)
			{
				\lib\router::set_controller("content_a\\gateway\\controller");
				return;
			}
			else
			{
				\lib\error::access();
			}
		}

		// route url like this /a/2kf/gateway
		if(preg_match("/^([a-zA-Z0-9]+)\/gateway(|\=[a-zA-Z0-9]+)$/", $url))
		{
			if($is_admin)
			{
				\lib\router::set_controller("content_a\\gateway\\controller");
				return;
			}
			else
			{
				\lib\error::access();
			}
		}

		/**
		 * route report urls
		 * in url must be find .../report/... | .../report
		 */
		if(preg_match("/(\/report\/)|(\/report$)/", $url))
		{
			\lib\temp::set('team_code_url', \lib\router::get_url(0));
			\lib\router::set_controller("content_a\\report\\controller");
			return;
		}

		// route url like this /a/2kf/houredit
		if(preg_match("/^([a-zA-Z0-9]+)\/houredit/", $url))
		{
			\lib\router::set_controller("content_a\\houredit\\controller");
			return;
		}

		// route url like this /a/2kf/houredit
		if(preg_match("/^([a-zA-Z0-9]+)\/sendnotify/", $url))
		{
			if($is_admin)
			{
				\lib\router::set_controller("content_a\\sendnotify\\controller");
				return;
			}
			else
			{
				\lib\error::access();
			}
		}


		// route url like this /a/2kf/houredit
		if(preg_match("/^([a-zA-Z0-9]+)\/option\/owner/", $url))
		{
			if($is_creator)
			{
				\lib\router::set_controller("content_a\\option\\owner\\controller");
				return;
			}
			else
			{
				\lib\error::access();
			}
		}

		// route url like this /a/2kf/houredit
		if(preg_match("/^([a-zA-Z0-9]+)\/option/", $url))
		{
			if($is_admin)
			{
				\lib\router::set_controller("content_a\\option\\controller");
				return;
			}
			else
			{
				\lib\error::access();
			}
		}


	}
}
?>