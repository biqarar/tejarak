<?php
namespace content_school\option\owner;

class view extends \content_school\main\view
{

	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_owner($_args)
	{
		$request_data = $this->model()->load_last_request();
		$this->data->sended_data = $request_data;
	}
}
?>