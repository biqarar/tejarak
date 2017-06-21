<?php
namespace content_a\main;

class model extends \mvc\model
{
	use \content_api\v1\home\tools\options;
	// // API BRANCH
	// use \content_api\v1\branch\tools\get;
	// use \content_api\v1\branch\tools\add;

	// API TEAM
	use \content_api\v1\team\tools\add;
	use \content_api\v1\team\tools\get;
	use \content_api\v1\team\tools\delete;

	// API MEMBER
	use \content_api\v1\member\tools\add;
	use \content_api\v1\member\tools\get;

	// API GETWAY
	use \content_api\v1\getway\tools\get;
	use \content_api\v1\getway\tools\add;

	// API FILE
	use \content_api\v1\file\tools\get;
	use \content_api\v1\file\tools\link;

	// API REPORT
	use \content_api\v1\report\tools\get;


	/**
	 * Gets the addbranch.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function getTeam($_args)
	{
		$this->user_id = $this->login('id');
		$team = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		\lib\utility::set_request_array(['team' => $team]);
		return $this->get_team();
	}


	/**
	 * load check brand of team exist or no
	 *
	 * @param      <type>   $_name   The name of brand
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function is_exist_team($_name)
	{
		$_name = \lib\utility\safe::safe($_name);

		if(!$this->login())
		{
			return false;
		}

		$search_team = \lib\db\teams::get(['shortname' => $_name, 'limit' => 1]);

		if($search_team)
		{
			return true;
		}
		return false;
	}
}
?>