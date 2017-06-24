<?php
namespace content\hours;

class view extends \mvc\view
{
	function config()
	{
		$this->data->bodyclass    = 'unselectable dash attendance';
		$this->data->current_time = date("Y-m-d H:i:s");
	}


	/**
	 * show hous page of team
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_show($_args)
	{
		$team = \lib\router::get_url();

		$request            = [];
		$this->data->team   = $request['shortname']         = $team;
		$this->data->list_member = $this->model()->list_member($request);

		$this->data->page['title'] = T_($team);
		$this->data->page['desc']  = T_('Setup is finished!');
	}
}
?>