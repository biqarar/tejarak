<?php
namespace content_a\report\year;


class view extends \content_a\report\view
{
	public function config()
	{
		parent::config();
		$this->data->page['title'] = T_('Report group by year');
		$this->data->page['desc']  = T_('check last attendace data and filter it based on member and see it for specefic member and exprort data of them.');
	}

	public function view_year()
	{
		$args           = [];
		$args['id']     = \lib\url::dir(0);
		$args['export'] = \lib\request::get('export');

		if(\lib\request::get('user'))
		{
			$args['user'] = \lib\request::get('user');
		}

		if(\lib\request::get('year'))
		{
			$args['year'] = \lib\request::get('year');
		}

		$this->data->year_time = $this->model()->get_year_time($args);

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}
	}
}
?>