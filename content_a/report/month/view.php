<?php
namespace content_a\report\month;

class view extends \content_a\report\view
{
	public function config()
	{
		parent::config();
	}

	public function view_month()
	{
		$args           = [];
		$args['id']   = \lib\router::get_url(0);
		$this->data->month_time = $this->model()->get_month_time($args);
		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}
	}
}
?>