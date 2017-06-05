<?php
namespace content_admin\branch_staff;

class view extends \content_admin\main\view
{
	use \content_api\v1\team\tools\get;



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
			$this->data->team = $url[0];
		}
	}


	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_liststaff($_args)
	{
		$result = $_args->api_callback;
		$this->data->staff_list = $result;
	}


	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_addstaff($_args)
	{
		$result = $_args->api_callback;
		$this->data->team = $result;
	}


	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_editstaff($_args)
	{
		$this->data->edit_mode = true;
		$result = $_args->api_callback;
		$this->data->staff = $result;
	}


	/**
	 * get team detail for edit
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_edit($_args)
	{
		$this->data->edit_mode = true;
		$result = $_args->api_callback;
		$this->data->team = $result;
	}


	/**
	 * { function_description }
	 */
	public function view_staffdashboard($_args)
	{
		$this->data->staff = $_args->api_callback;
	}




	/**
	 * { function_description }
	 */
	public function view_editstaff_team($_args)
	{
		$this->data->edit_mode = true;
		$this->data->staff = $_args->api_callback;
	}
}
?>