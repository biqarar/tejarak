<?php
namespace content\hours;

class view extends \mvc\view
{
	function config()
	{

	}


	/**
	 * show hous page of team
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_show($_args)
	{
		$team = \lib\router::get_url();

		$request            = [];
		$this->data->team   = $request['shortname']         = $team;
		$this->data->list_member = $this->model()->list_member($request);

	}
}
?>