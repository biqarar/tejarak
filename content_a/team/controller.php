<?php
namespace content_a\team;

class controller extends \content_a\main\controller
{
	/**
	 * route
	 */
	public function _route()
	{
		parent::_route();

		$url = \lib\router::get_url();

		// add team
		$this->get(false, 'add')->ALL('team');
		$this->post('add')->ALL('team');

		$code = \lib\router::get_url(0);

		// check the team exist or no and this user is the boss ot this team
		// this function in content_admi/main/model
		if($this->model()->is_exist_team_code($code))
		{
			$this->get(false, 'edit')->ALL("$code/edit");
			$this->post('edit')->ALL("$code/edit");
		}

		unset($_SESSION['first_go_to_setup']);
	}
}
?>