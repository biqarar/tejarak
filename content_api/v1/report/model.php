<?php
namespace content_api\v1\report;


class model extends \addons\content_api\v1\home\model
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
	 * Gets the report.
	 *
	 * @return     <type>  The report.
	 */
	public function get_report($_args)
	{
		if(isset($_args->match->url[0][1]))
		{
			return $this->get_report_result($_args->match->url[0][1]);
		}
		else
		{
			\lib\header::status(404, T_("Invalid url"));
		}

	}
}
?>