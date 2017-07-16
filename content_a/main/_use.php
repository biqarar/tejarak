<?php
namespace content_a\main;

trait _use
{
	// API OPTIONS
	use \content_api\v1\home\tools\options;

	// API HOURS
	use \content_api\v1\hours\tools\add;
	use \content_api\v1\hours\tools\get;

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

	// API FILE
	use \content_api\v1\file\tools\get;
	use \content_api\v1\file\tools\link;

	// API REPORT
	use \content_api\v1\report\tools\get;


	/**
	 * Gets the addmember.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function getTeamDetail($_team)
	{
		$request         = [];
		$this->user_id   = $this->login('id');
		$request['id'] = $_team;
		\lib\utility::set_request_array($request);
		$result = $this->get_team();
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
		\lib\utility::set_request_array($request);
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
		$_unique = \lib\utility\safe::safe($_unique);

		if(!$_unique)
		{
			return false;
		}

		$search_team = false;

		switch ($_type)
		{
			case 'code':
				$_unique = \lib\utility\shortURL::decode($_unique);
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
}
?>