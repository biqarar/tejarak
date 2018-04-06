<?php
namespace content_a\main;

class controller extends \mvc\controller
{

	/**
	 * rout
	 */
	public function repository()
	{
		if(\dash\temp::get('main_controller_is_run'))
		{
			return;
		}

		\dash\temp::set('main_controller_is_run', true);

		if(!\dash\user::login())
		{
			\dash\redirect::to(\dash\url::base(). '/enter');
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
		$url_0 = \dash\url::dir(0);
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
		if(!\dash\coding::is($url_0) && $url_0 != 'notifications')
		{
			\dash\header::status(404);
		}

		$team_id    = $url_0;
		$rule       = 'user';
		\dash\temp::set('team_code_url', $url_0);

		$team_id = \dash\coding::decode($team_id);

		if($team_id && \dash\user::id())
		{
			$team_details = \lib\db\teams::get_by_id($team_id);

			if(isset($team_details['creator']) && intval($team_details['creator']) === intval(\dash\user::id()))
			{
				\dash\temp::set('is_creator', true);
			}
			else
			{
				// team not found
				if(!$team_details)
				{
					\dash\header::status(404, T_("Team not found"));
				}
				else
				{
					\dash\temp::set('is_creator', false);
				}
			}

			$load_userteam_record = \lib\db\userteams::get(['team_id' => $team_id, 'user_id' => \dash\user::id(), 'limit' => 1]);

			\dash\temp::set('userteam_login_detail', $load_userteam_record);

			if(isset($load_userteam_record['rule']))
			{
				$rule = $load_userteam_record['rule'];
				if($rule === 'admin')
				{

					\dash\temp::set('is_admin', true);
				}
				else
				{
					\dash\temp::set('is_admin', false);
				}
			}
			else
			{
				// this user is not in this team
				if(!$load_userteam_record)
				{
					\dash\header::status(403);
				}
				else
				{
					// record is set but the rule is not in this record
					// this is a bug
					\dash\header::status(503);
				}
			}
		}

		$url_1 = \dash\url::dir(1);

		if(is_null($url_1))
		{
			\lib\engine\main::controller_set("content_a\\teamdashboard\\controller");
			return;
		}

		$url_2 = \dash\url::dir(2);

		$raw_url = $url_1;

		if($url_2)
		{
			$raw_url .= '\\'. $url_2;
		}

		$check_controller = '\\content_a\\'. $raw_url .'\\controller';
		if(class_exists($check_controller))
		{
			$this->have_permission($raw_url);

			\lib\engine\main::controller_set($check_controller);
			return;
		}
		else
		{
			\dash\header::status(404, T_("Invalid url"));
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
			case 'notifications':
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
				if(!\dash\temp::get('is_creator'))
				{
					\dash\header::status(403, T_("Can not access to load this page"));
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
				if(!\dash\temp::get('is_admin'))
				{
					\dash\header::status(403, T_("Can not access to load this page"));
				}
				break;
		}

	}

}
?>