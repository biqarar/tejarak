<?php
namespace content_s\home;
use \lib\debug;
use \lib\utility;

class model extends \content_s\main\model
{

	/**
	 * get list of teams of this user
	 */
	public function team_list()
	{
		if($this->login())
		{
			$this->user_id = $this->login('id');
			utility::set_request_array(['type' => 'school']);
			// API GET LIST TEAM FUNCTION
			return $this->get_list_team();
		}
	}
}
?>