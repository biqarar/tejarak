<?php
namespace content_s\billing\detail;

class view extends \content_s\main\view
{
	public function config()
	{
		parent::config();
	}


	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_detail($_args)
	{
		if(!$this->login())
		{
			return;
		}
		// var_dump($_args);exit();
		$detail = $_args->api_callback;
		$this->data->detail = $detail;

	}

}
?>