<?php
namespace content_api\v1\report;
use \lib\debug;
use \lib\utility;

class model extends \content_api\v1\home\model
{
	use tools\get;

	/**
	 * Gets the list.
	 *
	 * @return     array  The list.
	 */
	public function get_list()
	{
		return $this->report_list();
	}


	/**
	 * Gets the last trafic.
	 *
	 * @return     <type>  The last trafic.
	 */
	public function get_last_trafic()
	{
		return "2-Testing...";
	}


	/**
	 * Gets the enter exit.
	 *
	 * @return     <type>  The enter exit.
	 */
	public function get_enter_exit()
	{
		return "1-Testing... ";
	}
}
?>