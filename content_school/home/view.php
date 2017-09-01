<?php
namespace content_school\home;

class view extends \content_school\main\view
{
	public function config()
	{
		parent::config();
	}


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