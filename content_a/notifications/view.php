<?php
namespace content_a\notifications;

class view extends \content_a\main\view
{
	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_notifications($_args)
	{
		if(!\dash\user::login())
		{
			return;
		}

		$notify = $_args->api_callback;
		// var_dump($notify);exit();
		$this->data->notify = $notify;


		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}

	}

}
?>