<?php
namespace content_s\lesson;

class view extends \content_s\main\view
{

	/**
	 * { function_description }
	 */
	public function view_lesson()
	{
		$this->data->lesson_list = $data   = $this->model()->getListlesson();

		$this->data->page['title'] = T_('Add new lesson');
		$this->data->page['desc']  = $this->data->page['title'];
	}


	/**
	 * view to add team
	 */
	public function view_lesson_add()
	{
		$this->data->lesson_data   = $data = $this->model()->getReadyLesson();
		$this->data->page['title'] = T_('Add new lesson');
		$this->data->page['desc']  = $this->data->page['title'];
	}


	/**
	 * load team data to edit it
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_lesson_edit($_args)
	{
		$lesson_id = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		$this->data->lesson      = $this->model()->lessonEdit($lesson_id);
		$this->data->lesson_data = $this->model()->getReadyLesson();

		$this->data->edit_mode = true;

		$this->data->page['title'] = T_('Edit lesson');
		$this->data->page['desc']  = T_("Edit lesson");

	}


}
?>