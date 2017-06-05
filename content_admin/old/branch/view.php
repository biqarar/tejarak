<?php
namespace content_admin\branch;

class view extends \content_admin\main\view
{

	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_listbranch($_args)
	{
		if(isset($_args->api_callback['team']))
		{
			$this->data->team = $_args->api_callback['team'];
		}

		$result = $_args->api_callback;
		$this->data->result = $result;
	}


	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_addbranch($_args)
	{
		$this->data->team = $_args->api_callback;
	}


	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_editbranch($_args)
	{
		$this->data->team = $this->model()->getTeam($_args);
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
		$this->data->team = $this->model()->getTeam($_args);
		$this->data->edit_mode = true;
		$result = $_args->api_callback;
		$this->data->team = $result;
	}


	/**
	 * { function_description }
	 */
	public function view_branchdashboard($_args)
	{
		$this->data->team = $this->model()->getTeam($_args);
		$this->data->branch = $_args->api_callback;
	}
}
?>