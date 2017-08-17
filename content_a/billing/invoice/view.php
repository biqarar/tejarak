<?php
namespace content_a\billing\invoice;

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