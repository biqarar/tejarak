<?php
namespace content_a\report\period;


class model extends \content_a\main\model
{

	/**
	 * Gets the period time.
	 *
	 * @param      <type>  $_request  The arguments
	 */
	public function get_period_time($_request)
	{
		$this->user_id = $this->login('id');
		\lib\utility::set_request_array($_request);
		return $this->report_period_time();
	}
}
?>