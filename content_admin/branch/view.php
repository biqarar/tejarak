<?php
namespace content_admin\branch;

class view extends \content_admin\main\view
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
}
?>