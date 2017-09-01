<?php
namespace content_school\report\last;
use \lib\utility;

class view extends \content_school\report\view
{
	public function config()
	{
		parent::config();
	}

	public function view_last()
	{
		$args                  = [];
		$args['id']            = \lib\router::get_url(0);
		$this->data->team_code = $args['id'];

		if(utility::get('user'))
		{
			$args['user'] = utility::get('user');
		}

		$args['export'] = utility::get('export');

		$this->data->last_time = $this->model()->get_last_time($args);

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}
	}
}
?>