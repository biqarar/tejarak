<?php
namespace content_s\home;

class controller extends \content_s\main\controller
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
		// if($this->login('id') && !$this->login('setup'))
		// {
		// 	// if  the user is login and first login
		// 	// we set the setup field of user on 1
		// 	$_SESSION['user']['setup'] = '1';
		// 	\lib\db\users::update(['user_setup' => 1], $this->login('id'));

		// 	if(!\lib\db\userteams::get(['user_id' => $this->login('id'), 'status' => 'active', 'limit' => 1]))
		// 	{
		// 		$this->redirector()->set_domain()->set_url('a/setup')->redirect();
		// 		return;
		// 	}
		// }

		// check if the user is gateway redirect to hours page
		// if(!$this->login('mobile') && $this->login('parent') && $this->login('username') && $this->login('pass'))
		// {
		// 	$check_is_gateway = \lib\db\userteams::get(['user_id' => $this->login('id'), 'rule' => 'gateway', 'limit'=> 1]);
		// 	if(isset($check_is_gateway['team_id']))
		// 	{
		// 		$shortname = \lib\db\teams::get_by_id($check_is_gateway['team_id']);
		// 		if(isset($shortname['shortname']))
		// 		{
		// 			$this->redirector($this->view()->url->base. '/'. $shortname['shortname'])->redirect();
		// 			return;
		// 		}
		// 	}

		// }

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
					\lib\storage::set_is_creator(true);
					$is_creator = true;
				}
				else
				{
					\lib\storage::set_is_creator(false);
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
				\lib\storage::set_is_admin(true);
				break;

			default:
				\lib\storage::set_is_admin(false);
				break;
		}

		// route url like this /a/2kf
		if(preg_match("/^([a-zA-Z0-9]+)$/", $url))
		{
			\lib\router::set_controller("content_s\\dashboard\\controller");
			return;
		}

		// route url like this /a/2kf
		if
		(
			preg_match("/^([a-zA-Z0-9]+)\/edit$/", $url) ||
			preg_match("/^([a-zA-Z0-9]+)\/classroom$/", $url) ||
			preg_match("/^([a-zA-Z0-9]+)\/classroom\/add$/", $url) ||
			preg_match("/^([a-zA-Z0-9]+)\/classroom\=([a-zA-Z0-9]+)$/", $url)
		)
		{
			if($is_admin)
			{
				\lib\router::set_controller("content_s\\school\\controller");
				return;
			}
			else
			{
				\lib\error::access();
			}
		}

			// route url like this /a/2kf
		if
		(
			preg_match("/^([a-zA-Z0-9]+)\/lesson$/", $url) ||
			preg_match("/^([a-zA-Z0-9]+)\/lesson\/add$/", $url)
		)
		{
			if($is_admin)
			{
				\lib\router::set_controller("content_s\\lesson\\controller");
				return;
			}
			else
			{
				\lib\error::access();
			}
		}

		// route url like this /a/2kf/member
		if
		(
			preg_match("/^([a-zA-Z0-9]+)\/teacher$/", $url) ||
			preg_match("/^([a-zA-Z0-9]+)\/teacher\=([a-zA-Z0-9]+)$/", $url) ||
			preg_match("/^([a-zA-Z0-9]+)\/teacher\/add$/", $url) ||

			preg_match("/^([a-zA-Z0-9]+)\/student$/", $url) ||
			preg_match("/^([a-zA-Z0-9]+)\/student\=([a-zA-Z0-9]+)$/", $url) ||
			preg_match("/^([a-zA-Z0-9]+)\/student\/add$/", $url)
		)
		{
			if($is_admin)
			{
				\lib\router::set_controller("content_s\\member\\controller");
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
				\lib\router::set_controller("content_s\\plan\\controller");
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
				\lib\router::set_controller("content_s\\gateway\\controller");
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
				\lib\router::set_controller("content_s\\gateway\\controller");
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
			\lib\storage::set_team_code_url(\lib\router::get_url(0));
			\lib\router::set_controller("content_s\\report\\controller");
			return;
		}

		// route url like this /a/2kf/houredit
		if(preg_match("/^([a-zA-Z0-9]+)\/houredit/", $url))
		{
			\lib\router::set_controller("content_s\\houredit\\controller");
			return;
		}

		// route url like this /a/2kf/houredit
		if(preg_match("/^([a-zA-Z0-9]+)\/sendnotify/", $url))
		{
			if($is_admin)
			{
				\lib\router::set_controller("content_s\\sendnotify\\controller");
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
				\lib\router::set_controller("content_s\\option\\owner\\controller");
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
				\lib\router::set_controller("content_s\\option\\controller");
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