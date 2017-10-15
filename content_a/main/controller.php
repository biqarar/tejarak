<?php
namespace content_a\main;

class controller extends \mvc\controller
{

	/**
	 * rout
	 */
	public function repository()
	{
		if(!$this->login())
		{
			$this->redirector($this->url('base'). '/enter')->redirect();
			return;
		}

		$this->tejarak_controller_checker();
	}


	/**
	 * tejarak controller finder
	 * 2kf/module/child
	 */
	public function tejarak_controller_checker()
	{
		$url_0 = \lib\router::get_url(0);
		// the url in static page
		// return to get the url in her controller
		if($this->reservedNames($url_0) === true)
		{
			return;
		}

		// route the home controller to show list of team
		if($url_0 === '' || $url_0 === null)
		{
			return;
		}

		if($url_0 === 'setup')
		{
			return;
		}

		// if !the url 0 is a short url
		if(!\lib\utility\shortURL::is($url_0))
		{
			\lib\error::page();
		}

		$team_id    = $url_0;
		$rule       = 'user';
		\lib\temp::set('team_code_url', $url_0);

		$team_id = \lib\utility\shortURL::decode($team_id);

		if($team_id && $this->login('id'))
		{
			$team_details = \lib\db\teams::get_by_id($team_id);

			if(isset($team_details['creator']) && intval($team_details['creator']) === intval($this->login('id')))
			{
				\lib\temp::set('is_creator', true);
			}
			else
			{
				// team not found
				if(!$team_details)
				{
					\lib\error::page(T_("Team not found"));
				}
				else
				{
					\lib\temp::set('is_creator', false);
				}
			}

			$load_userteam_record = \lib\db\userteams::get(['team_id' => $team_id, 'user_id' => $this->login('id'), 'limit' => 1]);

			\lib\temp::set('userteam_login_detail', $load_userteam_record);

			if(isset($load_userteam_record['rule']))
			{
				$rule = $load_userteam_record['rule'];
				if($rule === 'admin')
				{

					\lib\temp::set('is_admin', true);
				}
				else
				{
					\lib\temp::set('is_admin', false);
				}
			}
			else
			{
				// this user is not in this team
				if(!$load_userteam_record)
				{
					\lib\error::access();
				}
				else
				{
					// record is set but the rule is not in this record
					// this is a bug
					\lib\error::service();
				}
			}
		}

		$url_1 = \lib\router::get_url(1);

		if(is_null($url_1))
		{
			\lib\router::set_controller("content_a\\teamdashboard\\controller");
			return;
		}

		$url_2 = \lib\router::get_url(2);

		$raw_url = $url_1;

		if($url_2)
		{
			$raw_url .= '\\'. $url_2;
		}

		$check_controller = '\\content_a\\'. $raw_url .'\\controller';
		if(class_exists($check_controller))
		{
			$this->have_permission($raw_url);

			\lib\router::set_controller($check_controller);
			return;
		}
		else
		{
			\lib\error::page(T_("Invalid url"));
		}
	}


	/**
	 * check reserved names
	 * @return [type] [description]
	 */
	function reservedNames($_name)
	{
		$result = null;
		switch ($_name)
		{
			case 'home':
			case 'team':
			case 'billing':
			case 'profile':
				$result = true;
				break;

			default:
				$result = false;
				break;
		}
		return $result;
	}


	/**
	 * check permission
	 *
	 * @param      <type>  $_controller  The controller
	 */
	public function have_permission($_controller)
	{
		switch ($_controller)
		{
			case 'setting\plan':
				if(!\lib\temp::get('is_creator'))
				{
					\lib\error::access(T_("Can not access to load this page"));
				}
				break;
			case 'report':
			case 'report\last':
			case 'report\year':
			case 'report\month':
			case 'report\period':
			case 'request':
			case 'request\add':
			case 'request\hour':
				return true;
				break;

			case 'setting':
			case 'member':
			default:
				if(!\lib\temp::get('is_admin'))
				{
					\lib\error::access(T_("Can not access to load this page"));
				}
				break;
		}

	}

}
?>