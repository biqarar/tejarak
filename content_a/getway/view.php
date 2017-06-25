<?php
namespace content_a\getway;

class view extends \content_a\main\view
{

	/**
	 * load team data
	 */
	public function load_current_team($_team)
	{
		$current_team = $this->model()->getTeamDetail($_team);
		return $current_team;
	}

	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_add($_args)
	{
		$team                      = \lib\router::get_url(0);
		$team_default              = $this->load_current_team($team);
		$this->data->current_team  = $this->data->team_default  = $team_default;

		$this->data->page['title'] = T_('Add new getway');
		$this->data->page['desc']  = $this->data->page['title'];
	}


	/**
	 * get list of getway on this team and branch
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_list($_args)
	{
		$team                     = \lib\router::get_url(0);
		$this->data->current_team = $this->load_current_team($team);
		$request                  = [];
		$request['id']            = $team;
		$list                     = $this->model()->list_getway($request);
		$this->data->list_getway  = $list;

		if(isset($this->data->current_team['name']))
		{
			$this->data->page['title'] = $this->data->current_team['name'];
			$this->data->page['desc']  = $this->data->page['title'];
		}
	}


	/**
	 * edit getway
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_edit($_args)
	{

		$this->data->edit_mode     = true;
		$url                       = \lib\router::get_url();
		$team                      = \lib\router::get_url(0);
		$this->data->current_team  = $this->load_current_team($team);
		$getway                    = substr($url, strpos($url,'=') + 1);
		$getway                    = $this->model()->edit($team, $getway);
		$this->data->getway        = $getway;

		if(isset($getway['displayname']))
		{
			$this->data->page['title'] = T_('Edit :name', ['name' => $getway['displayname']]);
		}
		else
		{
			$this->data->page['title'] = T_('Edit getway!');
		}
		$this->data->page['desc']  = $this->data->page['title'];

	}

}
?>