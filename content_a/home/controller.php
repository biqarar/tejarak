<?php
namespace content_a\home;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function ready()
	{
		// list of all team the user is them
		$this->get(false, 'dashboard')->ALL();

		// check if the user is gateway redirect to hours page
		if(!$this->login('mobile') && $this->login('parent') && $this->login('username') && $this->login('password'))
		{
			$check_is_gateway = \lib\db\userteams::get(['user_id' => $this->login('id'), 'rule' => 'gateway', 'limit'=> 1]);
			if(isset($check_is_gateway['team_id']))
			{
				$shortname = \lib\db\teams::get_by_id($check_is_gateway['team_id']);
				if(isset($shortname['shortname']))
				{
					$new_url = \lib\url::base(). '/'. $shortname['shortname'];
					\lib\redirect::to($new_url);
					return;
				}
			}
		}
	}
}
?>