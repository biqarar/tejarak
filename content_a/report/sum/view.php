<?php
namespace content_a\report\sum;
use \lib\utility;
use \lib\debug;

class view extends \content_a\report\view
{
	public function config()
	{
		parent::config();
	}

	public function view_sum()
	{
		if(utility::get('year') && is_numeric(utility::get('year')) && mb_strlen(utility::get('year')) === 4)
		{
			$this->data->get_year = utility::get('year');
		}

		if(utility::get('month') && is_numeric(utility::get('month')) && mb_strlen(utility::get('month')) <= 2)
		{
			$this->data->get_month = utility::get('month');
		}

		if(utility::get('day') && is_numeric(utility::get('day')) && mb_strlen(utility::get('day')) <= 2)
		{
			$this->data->get_day = utility::get('day');
		}

		$args =
		[
			'year'  => utility::get('year'),
			'month' => utility::get('month'),
			'day'   => utility::get('day'),
			'user'  => utility::get('user'),
		];
		$result = $this->model()->sum_report($args);
		$this->data->sum_report = $result;
		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}
	}
}
?>