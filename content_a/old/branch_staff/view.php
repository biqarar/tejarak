<?php
namespace content_a\branch_member;

class view extends \content_a\main\view
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
	public function view_listmember($_args)
	{
		$result = $_args->api_callback;
		$this->data->member_list = $result;
	}


	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_addmember($_args)
	{
		$result = $_args->api_callback;
		$this->data->team = $result;
	}


	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_editmember($_args)
	{
		$this->data->edit_mode = true;
		$result = $_args->api_callback;
		$this->data->member = $result;
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
	public function view_memberdashboard($_args)
	{
		$this->data->member = $_args->api_callback;
	}




	/**
	 * { function_description }
	 */
	public function view_editmember_team($_args)
	{
		$this->data->edit_mode = true;
		$this->data->member = $_args->api_callback;
	}
}
?>