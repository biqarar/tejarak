<?php
namespace content_a\billing\detail;

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