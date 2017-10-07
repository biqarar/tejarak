<?php
namespace content_a\setting\event;

class view extends \content_a\setting\view
{

	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_event($_args)
	{
		$request_data = [];
		$this->data->sended_data = $request_data;
	}
}
?>