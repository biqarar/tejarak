<?php
namespace content_admin\branch;

class view extends \content_admin\main\view
{
	use \content_api\v1\company\tools\get;



	/**
	 * { function_description }
	 */
	public function config()
	{
		$url = \lib\router::get_url();
		$url = \lib\utility\safe::safe($url);
		$url = explode('/', $url);
		if(isset($url[0]))
		{
			$this->data->company = $url[0];
		}
	}


	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_listbranch($_args)
	{
		$result = $_args->api_callback;
		$this->data->branch_list = $result;
	}


	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_addbranch($_args)
	{

	}


	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_editbranch($_args)
	{
		$this->data->edit_mode = true;
		$result = $_args->api_callback;
		$this->data->branch = $result;
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

	public function view_branchdashboard()
	{

	}
}
?>