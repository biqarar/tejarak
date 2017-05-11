<?php
namespace content_admin\getway;

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
	public function view_listgetway($_args)
	{
		$result = $_args->api_callback;
		$this->data->getway_list = $result;
	}


	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_addgetway($_args)
	{
		$result = $_args->api_callback;
		$this->data->company = $result;
	}


	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_editgetway($_args)
	{
		$this->data->edit_mode = true;
		$result = $_args->api_callback;
		$this->data->getway = $result;
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


	/**
	 * { function_description }
	 */
	public function view_getwaydashboard($_args)
	{
		$this->data->getway = $_args->api_callback;
	}




	/**
	 * { function_description }
	 */
	public function view_editgetway_company($_args)
	{
		$this->data->edit_mode = true;
		$this->data->getway = $_args->api_callback;
	}
}
?>