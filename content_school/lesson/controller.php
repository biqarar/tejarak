<?php
namespace content_school\lesson;

class controller extends \content_school\main\controller
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

		$this->get(false, 'lesson_add')->ALL("/^([a-zA-z0-9]+)\/lesson\/add$/");
		$this->post('lesson_add')->ALL("/^([a-zA-z0-9]+)\/lesson\/add$/");

		$this->get(false, 'lesson')->ALL("/^([a-zA-z0-9]+)\/lesson$/");
		$this->post(false, 'lesson')->ALL("/^([a-zA-z0-9]+)\/lesson$/");

		if(preg_match("/^([a-zA-z0-9]+)\/lesson$/", $url))
		{
			$this->display_name = 'content_school\lesson\list.html';
		}

		$code = \lib\router::get_url(0);

		// check the school exist or no and this user is the boss ot this school
		// this function in content_schooldmi/main/model
		if($this->model()->is_exist_team_code($code))
		{
			$this->get(false, 'edit')->ALL("$code/edit");
			$this->post('edit')->ALL("$code/edit");
		}

		unset($_SESSION['first_go_to_setup']);
	}
}
?>