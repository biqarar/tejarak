<?php
namespace content_a\main;

class view extends \mvc\view
{


	/**
	 * config
	 */
	public function config()
	{
		$this->data->bodyclass = 'fixed unselectable siftal';

		// get part 2 of url and use as team name
		$this->data->team = $this->data->team_code = \lib\router::get_url(0);

		if($this->reservedNames($this->data->team))
		{
			$this->data->team  = null;
		}

		$this->data->is_admin   = \lib\temp::get('is_admin');
		$this->data->is_creator = \lib\temp::get('is_creator');

		$this->data->display['adminTeam'] = 'content_a\main\layoutTeam.html';
		if($this->data->team)
		{
			$this->data->current_team = $this->model()->getTeamDetail($this->data->team);
		}

		if($this->login('id'))
		{
			// get count unread notifiation
			// $this->data->notification_count = \lib\db\notifications::unread($this->login('id'), true);
		}

	}
}
?>