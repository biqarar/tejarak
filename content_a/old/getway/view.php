<?php
namespace content_a\getway;

class view extends \content_a\main\view
{
	/**
	 * config
	 */
	public function config()
	{

	}

	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	*/
	public function view_listgetway($_args)
	{
		$this->view_addgetway($_args);
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
		$this->data->team = $this->model()->load_team($_args);
		$this->data->branch = $this->model()->load_branch($_args);
	}


	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	*/
	public function view_editgetway($_args)
	{
		$this->view_addgetway($_args);
		$this->data->edit_mode = true;
		$result = $_args->api_callback;
		$this->data->getway = $result;
	}


	/**
	 * get team detail for edit
	 *
	 * @param      <type>  $_args  The arguments
	*/
	public function view_edit($_args)
	{
		$this->view_addgetway($_args);
		$this->data->edit_mode = true;
		$result = $_args->api_callback;
		$this->data->team = $result;
	}


	/**
	 * { function_description }
	*/
	public function view_getwaydashboard($_args)
	{
		$this->view_addgetway($_args);
		$this->data->getway = $_args->api_callback;
	}

}
?>