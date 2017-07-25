<?php
namespace content_a\report\u;


class view extends \content_a\report\view
{
	public function config()
	{
		parent::config();
	}

	/**
	 * { function_description }
	 */
	public function view_u()
	{
		$args                  = [];
		$args['id']            = \lib\router::get_url(0);
		$this->data->team_code = $args['id'];
		$this->data->last_time = $this->model()->get_u_time($args);

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}
	}
}
?>