<?php
namespace content_a\main;

class controller extends \mvc\controller
{

	/**
	 * rout
	 */
	public function _route()
	{
		parent::_route();

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
			\lib\router::set_controller("\\content_a\\home\\controller");
			return;
		}
		// if !the url 0 is a short url
		if(!\lib\utility\shortURL::is($url_0))
		{
			\lib\error::page();
		}

		$team_id    = $url_0;
		$rule       = 'user';
		$is_creator = false;
		$is_admin   = false;

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

			if(isset($load_userteam_record['rule']))
			{
				$rule = $load_userteam_record['rule'];
				if($rule === 'admin')
				{
					$is_admin = true;
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
			\lib\router::set_controller("content_a\\dashboard\\controller");
			return;
		}

		$url_2 = \lib\router::get_url(2);
		$check_controller = '\\content_a\\'. $url_1 . '\\';

		if($url_2)
		{
			$check_controller .= $url_2 . '\\';
		}

		$check_controller .= 'controller';

		if(class_exists($check_controller))
		{
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
				$result = true;
				break;

			default:
				$result = false;
				break;
		}
		return $result;
	}

}
?>