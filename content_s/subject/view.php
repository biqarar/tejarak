<?php
namespace content_s\subject;

class view extends \content_s\main\view
{

	/**
	 * { function_description }
	 */
	public function view_subject()
	{
		$this->data->subject_list   = $this->model()->getListsubject();
		$this->data->page['title'] = T_('Add new subject');
		$this->data->page['desc']  = $this->data->page['title'];
	}


	/**
	 * view to add team
	 */
	public function view_subject_add()
	{
		$this->data->page['title'] = T_('Add new subject');
		$this->data->page['desc']  = $this->data->page['title'];
	}


	/**
	 * load team data to edit it
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_subject_edit($_args)
	{
		$subject_id = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		$this->data->subject = $this->model()->subjectEdit($subject_id);

		$this->data->edit_mode = true;

		if(isset($this->data->subject['title']))
		{
			$this->data->page['title'] = T_('Edit subject');
			$this->data->page['desc']  = T_("Edit subject :name", ['name' => $this->data->subject['title']]);
		}
	}


}
?>