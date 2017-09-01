<?php
namespace content_school\lesson;

class view extends \content_school\main\view
{
	/**
	 * { function_description }
	 */
	public function config()
	{
		parent::config();

		if($this->login('id'))
		{
			$owner_team_list = \lib\db\teams::get(['creator' => $this->login('id'), 'parent' => null]);
			$new_owner_team_list = [];
			if(is_array($owner_team_list))
			{
				$owner_team_list = array_column($owner_team_list, 'name', 'id');
				foreach ($owner_team_list as $key => $value)
				{
					$temp = \lib\utility\shortURL::encode($key);
					if($temp == \lib\router::get_url(0))
					{
						continue;
					}
					$new_owner_team_list[$temp] = $value;
				}
			}
			$this->data->owner_team = $new_owner_team_list;
		}
	}


	/**
	 * view to add team
	 */
	public function view_add()
	{
		$this->data->page['title'] = T_('Add new lesson');
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
		$this->data->team_detail = $this->model()->edit($team_code);

		$this->data->edit_mode = true;

		if(isset($this->data->team_detail['name']))
		{
			$this->data->page['title'] = T_('Edit lesson');
			$this->data->page['desc']  = T_("Edit lesson :name", ['name' => $this->data->team_detail['name']]);
		}
	}

	/**
	 * add new lesson
	 */
	public function view_lesson()
	{

	}

	public function view_lesson_add()
	{
		$this->data->page['title'] = T_('Add new lesson');
		$this->data->page['desc']  = $this->data->page['title'];

	}
}
?>