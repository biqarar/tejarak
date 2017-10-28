<?php
namespace content_a\request\add;

class view extends \content_a\report\view
{
	/**
	 * view to add team
	 */
	public function view_add()
	{
		$user_id = $this->login('id');
		$this->data->page['title'] = T_('Add new request');
		$this->data->page['desc']  = T_('You can add new request of time and after confirm of team admin, this time is added to your hours.');



	}
}
?>