<?php
namespace content_a\plan;

class view extends \mvc\view
{
	public function config()
	{

	}


	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_plan($_args)
	{
		$this->data->current_plan = $this->model()->plan();
	}

}
?>