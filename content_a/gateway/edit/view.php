<?php
namespace content_a\gateway\edit;

class view extends \content_a\main\view
{
	/**
	 * edit gateway
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_edit($_args)
	{

		$this->data->edit_mode = true;
		$url                   = \lib\router::get_url();
		$team                  = \lib\router::get_url(0);
		$gateway               = \lib\router::get_url(3);
		$gateway               = $this->model()->edit($team, $gateway);
		$this->data->gateway   = $gateway;

		if(isset($gateway['displayname']))
		{
			$this->data->page['title'] = T_('Edit :name', ['name' => $gateway['displayname']]);
		}
		else
		{
			$this->data->page['title'] = T_('Edit gateway!');
		}
		$this->data->page['desc']  = T_('change user and password of gateway or disable it.');

	}

}
?>