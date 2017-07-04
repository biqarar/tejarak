<?php
namespace content_a\plan;

class view extends \content_a\main\view
{


	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_plan($_args)
	{
		$this->data->current_plan = $this->model()->plan();

		$myTeam = 'myTeam';

		if(isset($this->data->current_plan['team_id']))
		{
			$team_code = \lib\utility\shortURL::encode($this->data->current_plan['team_id']);
			$current_team = $this->model()->getTeamDetail($team_code);

			if(isset($current_team['name']))
			{
				$myTeam = $current_team['name'];
			}
		}
		$this->data->page['title'] = T_('Change Plan of :name', ['name'=>$myTeam]);
		$this->data->page['desc']  = $this->data->page['title'];
	}

}
?>