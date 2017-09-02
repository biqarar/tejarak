<?php
namespace content_s\report\last;
use \lib\debug;
use \lib\utility;

class model extends \content_s\main\model
{

	/**
	 * Gets the last time.
	 *
	 * @param      <type>  $_request  The arguments
	 */
	public function get_last_time($_request)
	{
		$this->user_id = $this->login('id');
		utility::set_request_array($_request);
		return $this->report_last_time();
	}


	/**
	 * Posts a last.
	 */
	public function post_last()
	{
		$request            = [];
		$request['hour_id'] = utility::post('hour_id');
		$request['type']  = utility::post('type');
		$this->user_id      = $this->login('id');

		return $this->hour_change_type();

	}
}
?>