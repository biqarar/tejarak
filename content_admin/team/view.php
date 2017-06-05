<?php
namespace content_admin\team;

class view extends \content_admin\main\view
{

	/**
	 * view to add team
	 */
	public function view_add()
	{

	}

	/**
	 * load team data to edit it
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_edit($_args)
	{
		$name = $this->find_team_name_url($_args);
		if($name)
		{
			$this->data->team = $this->model()->edit($name);
		}
		$this->data->edit_mode = true;
	}
}
?>