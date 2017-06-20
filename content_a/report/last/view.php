<?php
namespace content_a\report\last;

class view extends \content_a\main\view
{
	public function view_last()
	{
		$args           = [];
		$args['team']   = \lib\router::get_url(0);
		$args['branch'] = \lib\router::get_url(1);
		$this->data->last_time = $this->model()->get_last_time($args);
	}
}
?>