<?php
namespace content_a\teamdashboard;

class view extends \content_a\main\view
{
	public function config()
	{

		parent::config();
		$team_name = '';
		if(isset($this->data->current_team['name']))
		{
			$team_name = $this->data->current_team['name'];
		}
		$this->data->page['title'] = T_('teamdashboard of :name', ['name'=> $team_name]);
		$this->data->page['desc'] = T_('Glance at your team summary and compare some important data together and enjoy Tejarak!'). ' '. T_('Have a good day;)');


	}
}
?>