<?php
namespace content_a\report\last;
use \lib\utility;

class view extends \content_a\report\view
{
	public function config()
	{
		parent::config();
		$this->data->page['title'] = T_('Last traffic reports');
		$this->data->page['desc']  = T_('check last attendace data and filter it based on member and see it for specefic member and exprort data of them.');
	}

	public function view_last()
	{
		$args                  = [];
		$args['id']            = \lib\url::dir(0);
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