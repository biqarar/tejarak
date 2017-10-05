<?php
namespace content_a\gateway;

class view extends \content_a\main\view
{

	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_add($_args)
	{
		$team                      = \lib\router::get_url(0);
		$this->data->team_default  = $team_default = $this->data->current_team;

		$this->data->page['title'] = T_('Add new gateway');
		$this->data->page['desc']  = T_('Allow to add specefic type of user that only allow to set enter and exit without more permission.');
	}


	/**
	 * get list of gateway on this team and branch
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_list($_args)
	{
		$team                     = \lib\router::get_url(0);
		$request                  = [];
		$request['id']            = $team;
		$list                     = $this->model()->list_gateway($request);
		$this->data->list_gateway  = $list;

		if(isset($this->data->current_team['name']))
		{
			$this->data->page['title'] = $this->data->current_team['name'];
			$this->data->page['desc']  = $this->data->page['title'];
		}

		$this->data->page['title'] = T_('gateway');
		$this->data->page['desc']  = T_('Gateway is a simple user that allow to see Tejarak board and set enter and exit of members.'). ' '. T_('This is useful when you dont want to login with your admin account and only want to register attendance data.');

	}


	/**
	 * edit gateway
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_edit($_args)
	{

		$this->data->edit_mode     = true;
		$url                       = \lib\router::get_url();
		$team                      = \lib\router::get_url(0);
		$gateway                    = substr($url, strpos($url,'=') + 1);
		$gateway                    = $this->model()->edit($team, $gateway);
		$this->data->gateway        = $gateway;

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