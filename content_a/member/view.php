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
		$this->data->list_member = $this->model()->list_member($request);

		if(isset($this->data->list_member['title']))
		{
			$this->data->page['title'] = T_('Edit team');
			$this->data->page['desc']  = T_("Edit team :name", ['name' => $this->data->list_member['title']]);
		}
	}

}
?>