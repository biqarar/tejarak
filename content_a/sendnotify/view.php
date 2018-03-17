<?php
namespace content_a\sendnotify;

class view extends \content_a\main\view
{
	public function config()
	{
		$this->data->page['title'] = T_("Send message as notify to team members");
		$this->data->page['desc']  = T_("You can send message to your team members and all of them if give this message as notification and if they are synced their telegram, they can give message in telegram");
	}



	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_sendnotify($_args)
	{
		if(!\lib\user::login())
		{
			return;
		}

		// $member = $this->model()->get_sendnotify();
		// $this->data->count_member = count($member);

	}

}
?>