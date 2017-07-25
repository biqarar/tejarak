<?php
namespace content_a\report\year;
use \lib\debug;
use \lib\utility;

class model extends \content_a\main\model
{

	/**
	 * Gets the year time.
	 *
	 * @param      <type>  $_request  The arguments
	 */
	public function get_year_time($_request)
	{
		$this->user_id = $this->login('id');
		utility::set_request_array($_request);
		return $this->report_year_time();
	}
}
?>