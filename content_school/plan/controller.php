<?php
namespace content_school\plan;

class controller extends  \content_school\main\controller
{

	public function _route()
	{
		$url = \lib\router::get_url();

		$team_code = \lib\router::get_url(0);

		/**
		 * check team is exist
		 */
		if(!$this->model()->is_exist_team_code($team_code))
		{
			\lib\error::page();
		}
		parent::_route();
		$this->get(false, "plan")->ALL("/^([a-zA-Z0-9]+)\/plan$/");
		$this->post("plan")->ALL("/^([a-zA-Z0-9]+)\/plan$/");
	}

}

?>