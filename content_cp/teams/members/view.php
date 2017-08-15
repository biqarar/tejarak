<?php
namespace content_cp\teams\members;

class view extends \mvc\view
{
	public function view_list($_args)
	{
		$this->data->team_id = \lib\router::get_url(2);

		$field = $this->controller()->fields;

		$list = $this->model()->members_list($_args, $field);

		$this->data->members_list = $list;

		$this->order_url($_args, $field);

		if(isset($this->controller->pagnation))
		{
			$this->data->pagnation = $this->controller->pagnation_get();
		}

		if(\lib\utility::get('search'))
		{
			$this->data->get_search = \lib\utility::get('search');
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