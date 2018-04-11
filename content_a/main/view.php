<?php
namespace content_a\main;

class view extends \mvc\view
{


	/**
	 * config
	 */
	public function repository()
	{
		$this->data->bodyclass = 'siftal';
		$this->include->css    = true;
		$this->include->chart  = true;


		// get part 2 of url and use as team name
		$this->data->team = $this->data->team_code = \dash\url::dir(0);

		if($this->reservedNames($this->data->team))
		{
			$this->data->team  = null;
		}

		$this->data->isAdmin   = \dash\temp::get('isAdmin');
		$this->data->isCreator = \dash\temp::get('isCreator');

		$this->data->display['adminTeam'] = 'content_a\main\layoutTeam.html';
		if($this->data->team)
		{
			$this->data->currentTeam = $this->model()->getTeamDetail($this->data->team);
		}

		$this->data->isAdmin       = \dash\temp::get('isAdmin');
		$this->data->isCreator     = \dash\temp::get('isCreator');

		if(\dash\user::id())
		{
			// get count unread notifiation
			// $this->data->notification_count = \dash\db\notifications::unread(\dash\user::id(), true);
		}

	}
}
?>