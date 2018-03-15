<?php
namespace content_a\report\period;


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
		if(\lib\utility::get('start'))
		{
			$this->data->get_start_date = \lib\utility::get('start');
		}

		if(\lib\utility::get('end'))
		{
			$this->data->get_end_date = \lib\utility::get('end');
		}

		$args           = [];
		$args['id']     = \lib\url::dir(0);
		$args['start']  = \lib\utility::get('start');
		$args['end']    = \lib\utility::get('end');
		$args['user']   = \lib\utility::get('user');
		$args['export'] = \lib\utility::get('export');
		$this->data->period_time = $this->model()->get_period_time($args);

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}
	}
}
?>