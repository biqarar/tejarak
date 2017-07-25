<?php
namespace content_a\report\day;
use \lib\debug;
use \lib\utility;

class model extends \content_a\main\model
{

	/**
	 * Gets the day time.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_day_time($_args)
	{
		$this->user_id = $this->login('id');
		$request       = [];
		$request['id'] = isset($_args['id']) ? $_args['id'] : null;
		utility::set_request_array($request);
		return $this->report_day_time();
	}
}
?>