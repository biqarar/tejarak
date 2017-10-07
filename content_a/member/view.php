<?php
namespace content_a\member;

class view extends \content_a\main\view
{

	public function config()
	{
		parent::config();

		$team                      = \lib\router::get_url(0);
		$member                    = \lib\router::get_url(3);
		if($member)
		{
			$member                    = $this->model()->edit($team, $member);
			$this->data->member        = $member;
		}
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
			$this->data->page['title'] = T_('Member of :name', ['name'=> $this->data->current_team['name']]);
			$this->data->page['desc']  = T_('Quick view to team members and add or edit detail of members');
		}
	}
}
?>