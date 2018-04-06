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
		if(\lib\request::get('year') && is_numeric(\lib\request::get('year')) && mb_strlen(\lib\request::get('year')) === 4)
		{
			$this->data->get_year = \lib\request::get('year');
		}

		if(\lib\request::get('month') && is_numeric(\lib\request::get('month')) && mb_strlen(\lib\request::get('month')) <= 2)
		{
			$this->data->get_month = \lib\request::get('month');
		}

		$args           = [];
		$args['id']     = \dash\url::dir(0);
		$args['year']   = \lib\request::get('year');
		$args['month']  = \lib\request::get('month');
		$args['user']   = \lib\request::get('user');
		$args['export'] = \lib\request::get('export') ? true : false;

		$this->data->month_time = $this->model()->get_month_time($args);

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}
	}
}
?>