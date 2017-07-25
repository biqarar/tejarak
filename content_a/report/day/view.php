<?php
namespace content_a\report\day;

class view extends \content_a\report\view
{
	public function config()
	{
		parent::config();
	}

	public function view_day()
	{
		$args           = [];
		$args['id']   = \lib\router::get_url(0);
		$this->data->day_time = $this->model()->get_day_time($args);
		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}
	}
}
?>