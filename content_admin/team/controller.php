<?php
namespace content_admin\team;

class controller extends \content_admin\main\controller
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

		// the url is team/ermile we remove team/ from first of url to get the 'ermile' [team brand]
		$name = str_replace('team/', '', $url);
		// check the team exist or no and this user is the boss ot this team
		// this function in content_admi/main/model
		if($this->model()->is_exist_team($name))
		{
			$this->get(false, 'edit')->ALL("team/$name");
			$this->post('edit')->ALL("team/$name");
		}
	}
}
?>