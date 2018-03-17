<?php
namespace content_a\home;


class model extends \content_a\main\model
{

	/**
	 * get list of teams of this user
	 */
	public function team_list()
	{
		if(\lib\user::login())
		{
			$this->user_id = \lib\user::id();
			// API GET LIST TEAM FUNCTION
			return $this->get_list_team();
		}
	}
}
?>