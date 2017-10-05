<?php
namespace content_a\report\month;
use \lib\utility;

class view extends \content_a\report\view
{
	public function config()
	{
		parent::config();
		$this->data->page['title'] = T_('Report group by month');
		$this->data->page['desc']  = T_('check last attendace data and filter it based on member and see it for specefic member and exprort data of them.');
	}


	/**
	 * view report month
	 */
	public function view_month()
	{
		if(utility::get('year') && is_numeric(utility::get('year')) && mb_strlen(utility::get('year')) === 4)
		{
			$this->data->get_year = utility::get('year');
		}

		if(utility::get('month') && is_numeric(utility::get('month')) && mb_strlen(utility::get('month')) <= 2)
		{
			$this->data->get_month = utility::get('month');
		}

		$args           = [];
		$args['id']     = \lib\router::get_url(0);
		$args['year']   = utility::get('year');
		$args['month']  = utility::get('month');
		$args['user']   = utility::get('user');
		$args['export'] = utility::get('export') ? true : false;

		$this->data->month_time = $this->model()->get_month_time($args);

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}
	}
}
?>