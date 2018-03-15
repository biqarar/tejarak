<?php
namespace content_a\main;
use \lib\utility;

trait _use
{
	// API OPTIONS
	use \addons\content_api\v1\home\tools\_use;

	// API HOURS
	use \content_api\v1\hours\tools\add;
	use \content_api\v1\hours\tools\get;
	use \content_api\v1\hours\tools\manage;


	// API HOURS EDIT REQUEST
	use \content_api\v1\houredit\tools\add;
	use \content_api\v1\houredit\tools\get;
	use \content_api\v1\houredit\tools\delete;
	use \content_api\v1\houredit\tools\action;

	// API TEAM
	use \content_api\v1\team\tools\add;
	use \content_api\v1\team\tools\get;
	use \content_api\v1\team\tools\close;

	// API MEMBER
	use \content_api\v1\member\tools\add;
	use \content_api\v1\member\tools\get;

	// API gateway
	use \content_api\v1\gateway\tools\get;
	use \content_api\v1\gateway\tools\add;

	// API REPORT
	use \content_api\v1\report\tools\get;


	/**
	 * check team language and redirect if is set
	 * the 'data' mean the arguments of this function is data of team
	 * you can set the id or shortname of team and change the data to 'id' or 'shortname'
	 */
	public function checkout_team_lanuage_force($_args = null, $_type = 'data')
	{
		$team_data = [];

		switch ($_type)
		{
			case 'data':
				$team_data = $_args;
				break;

			case 'id':
				if(is_numeric($_args))
				{
					$team_data = \lib\db\teams::get_by_id($_args);
				}
				break;

			case 'shortname':
				if(is_string($_args))
				{
					$team_data = \lib\db\teams::get_by_shortname($_args);
				}
				break;
		}

		/**
		 * { item_description }
		 */
		if(isset($team_data['language']))
		{
			$team_language = $team_data['language'];

			if(\lib\utility\location\languages::check($team_language))
			{
				$new_url               = \lib\url::pwd();
				$url                   = \lib\url::base();
				$url_property          = \lib\url::directory();
				$url_get               = utility::get();

				$site_language         = \lib\define::get_language();
				$site_language_default = \lib\define::get_language('default');

				if($team_language === $site_language)
				{
					// no thing
				}
				else
				{
					if($team_language === $site_language_default)
					{
						if($url_get)
						{
							$new_url = $url. '/'. $url_property. '?'. $url_get;
						}
						else
						{
							$new_url = $url. '/'. $url_property;
						}
					}
					else
					{
						if($url_get)
						{
							$new_url = $url. '/'. $team_language. '/'. $url_property. '?'. $url_get;
						}
						else
						{
							$new_url = $url. '/'. $team_language. '/'. $url_property;
						}
					}
				}
				if($new_url !== \lib\url::pwd())
				{
					$this->redirector($new_url)->redirect();
				}
			}
		}
	}


	/**
	 * Gets the addmember.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function getTeamDetail($_team)
	{
		$request       = [];
		$this->user_id = $this->login('id');
		$request['id'] = $_team;
		utility::set_request_array($request);
		$result        = $this->get_team(['debug' => false]);

		return $result;
	}


	/**
	 * Gets the addmember.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function getTeamDetailShortname($_shortname)
	{
		$request             = [];
		$this->user_id       = $this->login('id');
		$request['shortname'] = $_shortname;
		utility::set_request_array($request);
		$result = $this->get_team();
		return $result;
	}


	/**
	 * load check brand of team exist or no
	 *
	 * @param      <type>   $_name   The name of brand
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function is_exist_team_shortname($_shortname)
	{
		return $this->is_exist_team($_shortname, 'shortname');
	}


	/**
	 * Determines if exist team identifier.
	 *
	 * @param      <type>  $_id    The identifier
	 */
	public function is_exist_team_code($_code)
	{
		return $this->is_exist_team($_code, 'code');
	}

	/**
	 * Determines if exist team identifier.
	 *
	 * @param      <type>   $_id    The identifier
	 *
	 * @return     boolean  True if exist team identifier, False otherwise.
	 */
	public function is_exist_team_id($_id)
	{
		return $this->is_exist_team($_id, 'id');
	}

	/**
	 *
	 * load check brand of team exist or no
	 *
	 * @param      <type>   $_name   The name of brand
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function is_exist_team($_unique, $_type = null)
	{
		$_unique = utility\safe::safe($_unique);

		if(!$_unique)
		{
			return false;
		}

		$search_team = false;

		switch ($_type)
		{
			case 'code':
				$_unique = utility\shortURL::decode($_unique);
			case 'id':
				$search_team = \lib\db\teams::get(['id' => $_unique, 'limit' => 1]);
				break;
			case 'shortname':
				$search_team = \lib\db\teams::get(['shortname' => $_unique, 'limit' => 1]);
				break;
			default:
				return false;
				break;
		}
		return $search_team;
	}


	/**
	 * Gets the list.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function listMember($_team_id_or_code, $_type = 'id', $_args = [])
	{
		$this->user_id = $this->login('id');
		$request       = [];
		if($_type === 'id')
		{
			if(!is_numeric($_team_id_or_code))
			{
				return false;
			}
			$request['id'] = utility\shortURL::encode($_team_id_or_code);
		}
		elseif($_type === 'code')
		{
			$request['id'] = $_team_id_or_code;
		}
		else
		{
			return false;
		}

		utility::set_request_array($request);
		$result =  $this->get_list_member($_args);
		return $result;
	}
}
?>