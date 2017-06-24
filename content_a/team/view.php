<?php
namespace content_a\team;

class view extends \content_a\main\view
{

	/**
	 * view to add team
	 */
	public function view_add()
	{
		$this->data->page['title'] = T_('Add new team');
		$this->data->page['desc']  = $this->data->page['title'];
	}

	/**
	 * load team data to edit it
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_edit($_args)
	{
		$team_code = \lib\router::get_url(0);
		$this->data->team = $this->model()->edit($team_code);
		$this->data->edit_mode = true;

		if(isset($this->data->team['name']))
		{
			$this->data->page['title'] = T_('Edit team');
			$this->data->page['desc']  = T_("Edit team :name", ['name' => $this->data->team['name']]);
		}
	}
}
?>