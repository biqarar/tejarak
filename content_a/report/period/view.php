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
		if(\dash\request::get('start'))
		{
			$this->data->get_start_date = \dash\request::get('start');
		}

		if(\dash\request::get('end'))
		{
			$this->data->get_end_date = \dash\request::get('end');
		}

		$args           = [];
		$args['id']     = \dash\request::get('id');
		$args['start']  = \dash\request::get('start');
		$args['end']    = \dash\request::get('end');
		$args['user']   = \dash\request::get('user');
		$args['export'] = \dash\request::get('export');
		$this->data->period_time = $this->model()->get_period_time($args);

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}
	}
}
?>