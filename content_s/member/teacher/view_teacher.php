<?php
namespace content_s\member\teacher;

trait view_teacher
{

	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_teacher($_args)
	{
		$search = \lib\utility::get('search');
		$this->data->get_search = $search;
		$meta = [];
		$meta['search'] = $search;
		$this->data->teacher_list = $this->model()->getTeacherList($meta);



		$this->data->page['title'] = T_('Teacher list');
		$this->data->page['desc']  = $this->data->page['title'];
	}


	/**
	 * add new techer
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_teacher_add($_args)
	{
		$this->data->page['title'] = T_('Add new teacher');
		$this->data->page['desc']  = $this->data->page['title'];
	}


	/**
	 * edit teacher
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_teacher_edit($_args)
	{
		$teacher_id = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		$team_code = \lib\router::get_url(0);
		$this->data->teacher = $this->model()->editTeacher($team_code, $teacher_id);
		$this->data->edit_mode = true;
		$teacher_name = null;
		$this->data->page['title'] = T_('Edit teacher :name', ['name' => $teacher_name]);
		$this->data->page['desc']  = $this->data->page['title'];
	}

}
?>