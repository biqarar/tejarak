<?php
namespace content_a\sendnotify;

class view extends \content_a\main\view
{
	public function config()
	{
		parent::config();
	}



	/**
	 * { function_description }
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function view_sendnotify($_args)
	{
		if(!$this->login())
		{
			return;
		}

		// $member = $this->model()->get_sendnotify();
		// $this->data->count_member = count($member);

	}

}
?>