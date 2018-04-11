<?php
namespace content_a\report\month;


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
		if(\dash\request::get('year') && is_numeric(\dash\request::get('year')) && mb_strlen(\dash\request::get('year')) === 4)
		{
			$this->data->get_year = \dash\request::get('year');
		}

		if(\dash\request::get('month') && is_numeric(\dash\request::get('month')) && mb_strlen(\dash\request::get('month')) <= 2)
		{
			$this->data->get_month = \dash\request::get('month');
		}

		$args           = [];
		$args['id']     = \dash\request::get('id');
		$args['year']   = \dash\request::get('year');
		$args['month']  = \dash\request::get('month');
		$args['user']   = \dash\request::get('user');
		$args['export'] = \dash\request::get('export') ? true : false;

		$this->data->month_time = $this->model()->get_month_time($args);

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}
	}
}
?>