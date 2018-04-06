<?php
namespace content_a\gateway;

class view extends \content_a\main\view
{

	/**
	 * get list of gateway on this team and branch
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_list($_args)
	{
		$team                     = \dash\url::dir(0);
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

}
?>