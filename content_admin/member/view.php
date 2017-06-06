<?php
namespace content_admin\member;

class view extends \content_admin\main\view
{
	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_add($_args)
	{

	}


	/**
	 * get list of member on this team and branch
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_list($_args)
	{
		$request                 = [];
		$request['team']         = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		$request['branch']       = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		$this->data->list_member = $this->model()->list_member($request);
		// var_dump($this->data->list_member);exit();
	}

}
?>