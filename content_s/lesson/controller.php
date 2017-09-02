<?php
namespace content_s\lesson;

class controller extends \content_s\main\controller
{
	/**
	 * route
	 */
	public function _route()
	{
		parent::_route();

		$url = \lib\router::get_url();


		// ADD NEW lesson
		$this->get(false, 'lesson_add')->ALL("/^([a-zA-z0-9]+)\/lesson\/add$/");
		$this->post('lesson_add')->ALL("/^([a-zA-z0-9]+)\/lesson\/add$/");

		// LIST lesson
		$this->get(false, 'lesson')->ALL("/^([a-zA-z0-9]+)\/lesson$/");
		$this->post('lesson')->ALL("/^([a-zA-z0-9]+)\/lesson$/");

		// EDIT lesson
		$this->get(false, 'lesson_edit')->ALL("/^([a-zA-z0-9]+)\/lesson\=([a-zA-Z0-9]+)$/");
		$this->post('lesson_edit')->ALL("/^([a-zA-z0-9]+)\/lesson\=([a-zA-Z0-9]+)$/");

		if(preg_match("/^([a-zA-z0-9]+)\/lesson$/", $url))
		{
			$this->display_name = 'content_s\lesson\lessonList.html';
		}

	}
}
?>