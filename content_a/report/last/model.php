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
		$this->user_id = $this->login('id');
		\lib\utility::set_request_array($_request);
		return $this->report_last_time();
	}


	/**
	 * Posts a last.
	 */
	public function post_last()
	{
		$request            = [];
		$request['hour_id'] = \lib\request::post('hour_id');
		$request['type']  = \lib\request::post('type');
		$this->user_id      = $this->login('id');

		return $this->hour_change_type();

	}
}
?>