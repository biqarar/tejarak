<?php
namespace content_a\member\add;

class view extends \content_a\member\view
{
	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_add($_args)
	{
		$team                      = \dash\url::dir(0);
		$this->data->team_default  = $team_default = $this->data->currentTeam ;

		$this->data->page['title'] = T_('Add new member');
		$this->data->page['desc']  = T_('You can set detail of team member and assign some extra data to use later');
	}
}
?>