<?php
namespace content_a\report\month;


class model extends \content_a\main\model
{

	/**
	 * Gets the month time.
	 *
	 * @param      <type>  $_request  The arguments
	 */
	public function get_month_time($_request)
	{
		$this->user_id = \dash\user::id();
		\dash\app::variable($_request);
		return $this->report_month_time();
	}
}
?>