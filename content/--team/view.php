<?php
namespace content\team;

class view extends \content\main\view
{

	/**
	 * view to add team
	 */
	public function view_dashboard()
	{
		$this->data->team_list = $this->model()->team_list(false);
	}

}
?>