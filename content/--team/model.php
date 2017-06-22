<?php
namespace content\team;
use \lib\utility;
use \lib\debug;

class model extends \content\main\model
{



	/**
	 * get list of teams of this user
	 */
	public function team_list($_team)
	{
		$this->user_id = $this->login('id');
		// API GET LIST TEAM FUNCTION
		return $this->get_list_team_child(['team' => $_team, 'login' => $this->login()]);
	}
}
?>