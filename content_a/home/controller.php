<?php
namespace content_a\home;

class controller extends \content_a\main\controller
{
	/**
	 * rout
	 */
	function _route()
	{
		parent::_route();


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
					$new_url = $this->url('base'). '/'. $shortname['shortname'];
					$this->redirector($new_url)->redirect();
					return;
				}
			}
		}

		// if setup is null redirect to setup page
		// The user is the first time he uses the system,
		// so we will transfer him to the installation file
		// But before that we check that this user is not registered in any team.
		if($this->login('id') && !$this->login('setup'))
		{
			// if  the user is login and first login
			// we set the setup field of user on 1
			$_SESSION['user']['setup'] = '1';
			\lib\db\users::update(['setup' => 1], $this->login('id'));

			if(!\lib\db\userteams::get(['user_id' => $this->login('id'), 'status' => 'active', 'limit' => 1]))
			{
				$this->redirector()->set_domain()->set_url('a/setup')->redirect();
				return;
			}
		}

	}
}
?>