<?php
namespace content_a\main;

class model extends \mvc\model
{
	/**
	 * USE ALL API FUNCTION
	 */
	use _use;

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

	/**
	 *
	 * load check brand of team exist or no
	 *
	 * @param      <type>   $_name   The name of brand
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function is_exist_team_id($_id)
	{
		if(!$this->login())
		{
			return false;
		}

		$search_team = \lib\db\teams::get(['id' => $_id, 'limit' => 1]);

		if($search_team)
		{
			return true;
		}
		return false;
	}
}
?>