<?php
namespace content_s\member;

class controller extends \content_s\main\controller
{
	/**
	 * rout
	 */
	public function _route()
	{
		parent::_route();

		$url = \lib\router::get_url();

		$team_code = \lib\router::get_url(0);
		/**
		 * check team is exist
		 */
		if(!$this->model()->is_exist_team_code($team_code))
		{
			\lib\error::page();
		}
		/**
		 * TEACHERS
		 */
		// LIST
		$this->get(false, 'teacher')->ALL("/^([a-zA-Z0-9]+)\/teacher$/");
		$this->post('teacher')->ALL("/^([a-zA-Z0-9]+)\/teacher$/");
		// ADD NEW
		$this->get(false, 'teacher_add')->ALL("/^([a-zA-Z0-9]+)\/teacher\/add$/");
		$this->post('teacher_add')->ALL("/^([a-zA-Z0-9]+)\/teacher\/add$/");
		// EDIT
		$this->get(false, 'teacher_edit')->ALL("/^([a-zA-Z0-9]+)\/teacher\=([a-zA-Z0-9]+)$/");
		$this->post('teacher_edit')->ALL("/^([a-zA-Z0-9]+)\/teacher\=([a-zA-Z0-9]+)$/");

		/**
		 * STUDENT
		 */
		// LIST
		$this->get(false, 'student')->ALL("/^([a-zA-Z0-9]+)\/student$/");
		$this->post('student')->ALL("/^([a-zA-Z0-9]+)\/student$/");
		// ADD NEW
		$this->get(false, 'student_add')->ALL("/^([a-zA-Z0-9]+)\/student\/add$/");
		$this->post('student_add')->ALL("/^([a-zA-Z0-9]+)\/student\/add$/");
		// EDIT
		$this->get(false, 'student_edit')->ALL("/^([a-zA-Z0-9]+)\/student\=([a-zA-Z0-9]+)$/");
		$this->post('student_edit')->ALL("/^([a-zA-Z0-9]+)\/student\=([a-zA-Z0-9]+)$/");


		// student list
		if(preg_match("/^([a-zA-Z0-9]+)\/student$/", $url))
		{
			$this->display_name = 'content_s\member\student\student.html';
		}
		// teahcer list
		if(preg_match("/^([a-zA-Z0-9]+)\/teacher$/", $url))
		{
			$this->display_name = 'content_s\member\teacher\teacher.html';
		}
		// add new student
		if(preg_match("/^([a-zA-Z0-9]+)\/teacher\/add$/", $url) || preg_match("/^([a-zA-Z0-9]+)\/teacher\=([a-zA-Z0-9]+)$/", $url))
		{
			$this->display_name = 'content_s\member\teacher\teacher_add.html';
		}
		// student add
		if(preg_match("/^([a-zA-Z0-9]+)\/student\/add$/", $url) || preg_match("/^([a-zA-Z0-9]+)\/student\=([a-zA-Z0-9]+)$/", $url))
		{
			$this->display_name = 'content_s\member\student\student_add.html';
		}

		// unroute url /a/member
		if($url === 'member')
		{
			\lib\error::page();
		}

		/**
		 * check if user not permission to load data
		 * redirect to show her report
		 * the user must be redirect to report page
		 */
		if(!\lib\storage::get_is_admin())
		{
			$this->redirector()->set_domain()->set_url('s/'.$team_code.'/report')->redirect();
			return;
		}

	}
}
?>