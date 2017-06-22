<?php
namespace content_a\member;

class view extends \content_a\main\view
{
	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_add($_args)
	{
		$this->data->page['title'] = T_('Add new member');
		$this->data->page['desc']  = $this->data->page['title'];
		$team                      = \lib\router::get_url(1);
		$team_default              = $this->model()->getTeamDetail($team);
		$this->data->team_default  = $team_default;
		// var_dump($team_default);exit();
		// fix title on edit
		if(isset($this->data->list_member['title']))
		{
			$this->data->page['title'] = T_('Edit team');
			$this->data->page['desc']  = T_("Edit team :name", ['name' => $this->data->list_member['title']]);
		}
	}


	/**
	 * get list of member on this team and branch
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_list($_args)
	{
		$team                    = \lib\router::get_url(0);
		$request                 = [];
		$this->data->team        = $request['id'] = $team;
		$list = $this->model()->list_member($request);
		$this->data->list_member = $list;
		if(isset($this->data->list_member['title']))
		{
			$this->data->page['title'] = T_('Edit team');
			$this->data->page['desc']  = T_("Edit team :name", ['name' => $this->data->list_member['title']]);
		}
	}


	/**
	 * edit member
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_edit($_args)
	{
		$this->data->page['title'] = T_('Edit member');
		$this->data->page['desc']  = $this->data->page['title'];
		$this->data->edit_mode = true;
		$url = \lib\router::get_url();
		$team = \lib\router::get_url(1);
		$member = substr($url, strpos($url,'=') + 1);
		$member = $this->model()->edit($team, $member);
		$this->data->member = $member;
	}

}
?>