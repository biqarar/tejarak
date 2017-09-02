<?php
namespace content_s\school\classroom;

trait view_classroom
{
	/**
	 * add new classroom
	 */
	public function view_classroom()
	{
		$this->data->page['title'] = T_('Classroom list');
		$this->data->page['desc']  = $this->data->page['title'];

		$meta = [];
		$meta['search'] = \lib\utility::get('search');

		$this->data->classroom_list = $this->model()->classroomList($meta);

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}
	}


	/**
	 * add new classroom
	 */
	public function view_classroom_add()
	{
		$this->data->page['title'] = T_('Add new classroom');
		$this->data->page['desc']  = $this->data->page['title'];
	}


	public function view_classroom_edit($_args)
	{
		$team_code = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		if($team_code)
		{
			$this->data->team_detail = $this->model()->editClassroom($team_code);
		}

		$this->data->edit_mode = true;

		if(isset($this->data->team_detail['name']))
		{
			$this->data->page['title'] = T_('Edit Classroom');
			$this->data->page['desc']  = T_("Edit Classroom :name", ['name' => $this->data->team_detail['name']]);
		}
	}
}
?>