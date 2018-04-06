<?php
namespace content_cp\teams\hours;

class view extends \content_cp\main\view
{
	public function view_list($_args)
	{
		$this->data->team_id = \dash\url::dir(2);

		$field = $this->controller()->fields;

		$list = $this->model()->hours_list($_args, $field);

		$this->data->hours_list = $list;

		$this->order_url($_args, $field);

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}

		if(\lib\request::get('search'))
		{
			$this->data->get_search = \lib\request::get('search');
		}
	}


	/**
	 * MAKE ORDER URL
	 *
	 * @param      <type>  $_args    The arguments
	 * @param      <type>  $_fields  The fields
	 */
	public function order_url($_args, $_fields)
	{
		$order_url = [];
		foreach ($_fields as $key => $value)
		{
			if(strpos($_args->match->url[0][0], 'asc'))
			{
				$order_url[$value] = "sort=$value/order=desc";
			}
			else
			{
				$order_url[$value] = "sort=$value/order=asc";
			}
		}

		$this->data->order_url = $order_url;
	}
}
?>