<?php
namespace content_admin\team;

class view extends \content_admin\main\view
{

	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_list($_args)
	{
		$result = $_args->api_callback;
		$this->data->team_list = $result;
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
		$this->data->team = $result;
	}


	/**
	 * view for delete
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_delete($_args)
	{
		$this->data->delete_mode = true;
		$result = $_args->api_callback;

		$this->data->team_list = $result;
	}


	/**
	 * get the dashboard of this counpany
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_dashboard($_args)
	{
		$result = $_args->api_callback;
		$this->data->team = $result;
	}
}
?>