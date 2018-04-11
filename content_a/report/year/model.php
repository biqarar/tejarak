<?php
namespace content_a\report\year;


class model extends \content_a\main\model
{

	/**
	 * Gets the year time.
	 *
	 * @param      <type>  $_request  The arguments
	 */
	public function get_year_time($_request)
	{
		$this->user_id = \dash\user::id();
		\dash\app::variable($_request);
		return $this->report_year_time();
	}
}
?>