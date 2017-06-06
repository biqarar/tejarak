<?php
namespace content_admin\home;
use \lib\debug;
use \lib\utility;

class model extends \content_admin\main\model
{

	/**
	 * get list of teams of this user
	 */
	public function team_list()
	{
		if($this->login())
		{
			$this->user_id = $this->login('id');
			// API GET LIST TEAM FUNCTION
			return $this->get_list_team_child();
		}
	}
}
?>