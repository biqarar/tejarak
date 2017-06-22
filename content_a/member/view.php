<?php
namespace content_a\member;

class view extends \content_a\main\view
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
		$team                    = \lib\router::get_url(0);
		$request                 = [];
		$this->data->team        = $request['shortname'] = $team;
		$this->data->list_member = $this->model()->list_member($request);
	}

}
?>