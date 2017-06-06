<?php
namespace content_admin\home;

class view extends \content_admin\main\view
{
	/**
	 * view all team and branch
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_dashboard($_args)
	{
		$this->data->team_list = $this->model()->team_list();
	}
}
?>