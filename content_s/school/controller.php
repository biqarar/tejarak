<?php
namespace content_s\school;

class controller extends \content_s\main\controller
{
	/**
	 * route
	 */
	public function _route()
	{
		parent::_route();

		$url = \lib\router::get_url();

		// add school
		$this->get(false, 'add')->ALL('school');
		$this->post('add')->ALL('school');

		$this->get(false, 'classroom_add')->ALL("/^([a-zA-z0-9]+)\/classroom\/add$/");
		$this->post('classroom_add')->ALL("/^([a-zA-z0-9]+)\/classroom\/add$/");

		$this->get(false, 'classroom')->ALL("/^([a-zA-z0-9]+)\/classroom$/");
		$this->post(false, 'classroom')->ALL("/^([a-zA-z0-9]+)\/classroom$/");

		if(preg_match("/^([a-zA-z0-9]+)\/classroom$/", $url))
		{
			$this->display_name = 'content_s\school\list.html';
		}

		$code = \lib\router::get_url(0);

		// check the school exist or no and this user is the boss ot this school
		// this function in content_sdmi/main/model
		if($this->model()->is_exist_team_code($code))
		{
			$this->get(false, 'edit')->ALL("$code/edit");
			$this->post('edit')->ALL("$code/edit");
		}

		unset($_SESSION['first_go_to_setup']);
	}
}
?>