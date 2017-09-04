<?php
namespace content_s\member\student;

trait view_student
{

	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_student($_args)
	{
		$search = \lib\utility::get('search');
		$this->data->get_search = $search;
		$meta = [];
		$meta['search'] = $search;
		$this->data->student_list = $this->model()->getstudentList($meta);



		$this->data->page['title'] = T_('student list');
		$this->data->page['desc']  = $this->data->page['title'];
	}


	/**
	 * add new techer
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_student_add($_args)
	{
		$this->data->page['title'] = T_('Add new student');
		$this->data->page['desc']  = $this->data->page['title'];
	}


	/**
	 * edit student
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_student_edit($_args)
	{
		$student_id                = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		$team_code                 = \lib\router::get_url(0);
		$this->data->student       = $this->model()->editstudent($team_code, $student_id);

		$this->data->edit_mode     = true;
		$student_name              = null;
		$this->data->page['title'] = T_('Edit student :name', ['name' => $student_name]);
		$this->data->page['desc']  = $this->data->page['title'];
	}

}
?>