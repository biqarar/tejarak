<?php
namespace content_a\home;

class view extends \content_a\main\view
{
	public function config()
	{
		parent::config();
		$this->data->page['title'] = T_("Dashboard");
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