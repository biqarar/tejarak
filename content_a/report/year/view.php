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
		$args['export'] = \lib\utility::get('export');

		if(\lib\utility::get('user'))
		{
			$args['user'] = \lib\utility::get('user');
		}

		if(\lib\utility::get('year'))
		{
			$args['year'] = \lib\utility::get('year');
		}

		$this->data->year_time = $this->model()->get_year_time($args);

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}
	}
}
?>