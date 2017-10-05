<?php
namespace content_a\setting\telegram;

class view extends \content_a\main\view
{

	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_telegram($_args)
	{
		$request_data = [];
		$this->data->sended_data = $request_data;
	}
}
?>