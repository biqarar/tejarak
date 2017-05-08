<?php
namespace content_admin\company;

class view extends \content_admin\main\view
{
	use \content_api\v1\company\tools\get;

	public function view_list($_args)
	{
		$result = $_args->api_callback;
		$this->data->company_list = $result;
	}

	/**
	 * get comapny detail for edit
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_edit($_args)
	{
		$this->data->edit_mode = true;
		$result = $_args->api_callback;
		$this->data->company = $result;
	}
}
?>