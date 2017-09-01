<?php
namespace content_school\dashboard;

class view extends \content_school\main\view
{
	/**
	 * { function_description }
	 */
	public function config()
	{
		parent::config();
	}


	/**
	 * view to add team
	 */
	public function view_add()
	{
		if(isset($this->data->current_team['name']))
		{
			$this->data->page['title'] = $this->data->current_team['name'];
		}
		else
		{
			$this->data->page['title'] = T_('School panel');
		}

		$this->data->page['desc']  = $this->data->page['title'];
	}

}
?>