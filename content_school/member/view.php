<?php
namespace content_school\member;

class view extends \content_school\main\view
{



	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_add($_args)
	{
		$team                      = \lib\router::get_url(0);
		$this->data->team_default  = $team_default = $this->data->current_team ;

		$this->data->page['title'] = T_('Add new member');
		$this->data->page['desc']  = $this->data->page['title'];
	}


	/**
	 * get list of member on this team and branch
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_list($_args)
	{
		$team                     = \lib\router::get_url(0);
		$request                  = [];
		$request['id']            = $team;
		$list                     = $this->model()->list_member($request);
		$this->data->list_member  = $list;

		if(isset($this->data->current_team['name']))
		{
			$this->data->page['title'] = $this->data->current_team['name'];
			$this->data->page['desc']  = $this->data->page['title'];
		}
	}


	/**
	 * edit member
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_edit($_args)
	{

		$this->data->edit_mode     = true;
		$url                       = \lib\router::get_url();
		$team                      = \lib\router::get_url(0);
		$member                    = substr($url, strpos($url,'=') + 1);
		$member                    = $this->model()->edit($team, $member);
		$this->data->member        = $member;

		if(isset($member['displayname']))
		{
			$this->data->page['title'] = T_('Edit :name', ['name' => $member['displayname']]);
		}
		else
		{
			$this->data->page['title'] = T_('Edit member!');
		}
		$this->data->page['desc']  = $this->data->page['title'];

	}

}
?>