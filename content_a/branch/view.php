<?php
namespace content_a\branch;

class view extends \content_a\main\view
{

	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_add($_args)
	{

	}


	/**
	 * get team detail for edit
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_edit($_args)
	{
		$this->data->branch = $this->model()->edit($_args);
		$this->data->edit_mode = true;
	}


	public function view_dashboard($_args)
	{
		$team = (isset($_args->match->url[0]) &&  is_string($_args->match->url[0])) ? $_args->match->url[0] : null;
		$this->data->branch_list = $this->model()->branch_list($team);
		// var_dump($this->data->branch_list);exit();
	}
}
?>