<?php
namespace content_a\report\year;
use \lib\utility;

class view extends \content_a\report\view
{
	public function config()
	{
		parent::config();
	}

	public function view_year()
	{
		$args           = [];
		$args['id']   = \lib\router::get_url(0);

		if(utility::get('user'))
		{
			$args['user'] = utility::get('user');
		}

		if(utility::get('year'))
		{
			$args['year'] = utility::get('year');
		}

		$this->data->year_time = $this->model()->get_year_time($args);

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}
	}
}
?>