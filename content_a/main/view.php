<?php
namespace content_a\main;

class view extends \mvc\view
{
	public function config()
	{
		$this->data->bodyclass = 'fixed unselectable dash';

		// get part 2 of url and use as team name
		$this->data->team = $this->data->team_code = \lib\router::get_url(0);

		if($this->reservedNames($this->data->team))
		{
			$this->data->team  = null;
		}



		$this->data->display['adminTeam'] = 'content_a\main\layoutTeam.html';
	}
}
?>