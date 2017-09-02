<?php
namespace content_s\billing\invoice;

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
	public function view_invoice($_args)
	{
		if(!$this->login())
		{
			return;
		}

		$invoice = $_args->api_callback;
		$this->data->invoice = $invoice;

	}

}
?>