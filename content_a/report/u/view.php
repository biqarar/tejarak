<?php
namespace content_a\report\u;

class view extends \content_a\main\view
{
	public function view_last()
	{
		$args           = [];
		$args['team']   = \lib\router::get_url(0);
		$this->data->last_time = $this->model()->get_last_time($args);
	}
}
?>