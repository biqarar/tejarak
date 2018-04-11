<?php
namespace lib\app;


class team
{
	use \lib\app\team\add;
	use \lib\app\team\get;
	use \lib\app\team\close;
	use \lib\app\team\delete;


	/**
	 * check team language and redirect if is set
	 * the 'data' mean the arguments of  function is data of team
	 * you can set the id or shortname of team and change the data to 'id' or 'shortname'
	 */
	public static function checkout_team_lanuage_force($_args = null, $_type = 'data')
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

			if(\dash\language::check($team_language))
			{
				$new_url               = \dash\url::pwd();
				$url                   = \dash\url::base();
				$url_property          = \dash\url::directory();
				$url_get               = \dash\request::get();

				$site_language         = \dash\language::current();
				$site_language_default = \dash\language::default();

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
				if($new_url !== \dash\url::pwd())
				{
					\dash\redirect::to($new_url);
				}
			}
		}
	}


	/**
	 * Gets the addmember.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function getTeamDetail($_team)
	{
		$request       = [];

		$request['id'] = $_team;
		\dash\app::variable($request);
		$result        = self::get_team(['debug' => false]);

		return $result;
	}


	/**
	 * Gets the addmember.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function getTeamDetailShortname($_shortname)
	{
		$request             = [];

		$request['shortname'] = $_shortname;
		\dash\app::variable($request);
		$result = self::get_team();
		return $result;
	}


	/**
	 * load check brand of team exist or no
	 *
	 * @param      <type>   $_name   The name of brand
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function is_exist_team_shortname($_shortname)
	{
		return self::is_exist_team($_shortname, 'shortname');
	}


	/**
	 * Determines if exist team identifier.
	 *
	 * @param      <type>  $_id    The identifier
	 */
	public static function is_exist_team_code($_code)
	{
		return self::is_exist_team($_code, 'code');
	}

	/**
	 * Determines if exist team identifier.
	 *
	 * @param      <type>   $_id    The identifier
	 *
	 * @return     boolean  True if exist team identifier, False otherwise.
	 */
	public static function is_exist_team_id($_id)
	{
		return self::is_exist_team($_id, 'id');
	}

	/**
	 *
	 * load check brand of team exist or no
	 *
	 * @param      <type>   $_name   The name of brand
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function is_exist_team($_unique, $_type = null)
	{
		$_unique = \dash\safe::safe($_unique);

		if(!$_unique)
		{
			return false;
		}

		$search_team = false;

		switch ($_type)
		{
			case 'code':
				$_unique = \dash\coding::decode($_unique);
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
	public static function listMember($_team_id_or_code, $_type = 'id', $_args = [])
	{

		$request       = [];
		if($_type === 'id')
		{
			if(!is_numeric($_team_id_or_code))
			{
				return false;
			}
			$request['id'] = \dash\coding::encode($_team_id_or_code);
		}
		elseif($_type === 'code')
		{
			$request['id'] = $_team_id_or_code;
		}
		else
		{
			return false;
		}

		\dash\app::variable($request);
		$result =  self::get_list_member($_args);
		return $result;
	}
}
?>