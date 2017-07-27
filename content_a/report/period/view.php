<?php
namespace content_a\report\period;

class view extends \content_a\report\view
{
	public function config()
	{
		parent::config();
	}

	public function view_period()
	{
		$args           = [];
		$args['id']   = \lib\router::get_url(0);
		$this->data->period_time = $this->model()->get_period_time($args);
		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}
	}
}
?>