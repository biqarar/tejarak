<?php
namespace content_a\report\last;


class model extends \content_a\main\model
{

	/**
	 * Gets the last time.
	 *
	 * @param      <type>  $_request  The arguments
	 */
	public function get_last_time($_request)
	{
		$this->user_id = \dash\user::id();
		\dash\app::variable($_request);
		return $this->report_last_time();
	}


	/**
	 * Posts a last.
	 */
	public function post_last()
	{
		$request            = [];
		$request['hour_id'] = \dash\request::post('hour_id');
		$request['type']  = \dash\request::post('type');
		$this->user_id      = \dash\user::id();

		return $this->hour_change_type();

	}
}
?>