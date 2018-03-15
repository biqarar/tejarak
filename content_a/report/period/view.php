<?php
namespace content_a\report\period;
use \lib\utility;

class view extends \content_a\report\view
{
	public function config()
	{
		parent::config();
		$this->data->page['title'] = T_('Report in period of time');
		$this->data->page['desc']  = T_('check last attendace data and filter it based on member and see it for specefic member and exprort data of them.');
	}

	public function view_period()
	{
		if(utility::get('start'))
		{
			$this->data->get_start_date = utility::get('start');
		}

		if(utility::get('end'))
		{
			$this->data->get_end_date = utility::get('end');
		}

		$args           = [];
		$args['id']     = \lib\url::dir(0);
		$args['start']  = utility::get('start');
		$args['end']    = utility::get('end');
		$args['user']   = utility::get('user');
		$args['export'] = utility::get('export');
		$this->data->period_time = $this->model()->get_period_time($args);

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}
	}
}
?>