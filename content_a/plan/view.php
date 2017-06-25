<?php
namespace content_a\plan;

class view extends \content_a\main\view
{


	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_plan($_args)
	{
		$this->data->current_plan = $this->model()->plan();
		$this->data->page['title'] = T_('Change Plan of :name', ['name'=>'myTeam']);
		$this->data->page['desc']  = $this->data->page['title'];
	}

}
?>