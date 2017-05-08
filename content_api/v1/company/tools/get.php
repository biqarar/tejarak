<?php
namespace content_api\v1\company\tools;

trait get
{
	/**
	 * Gets the company.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The company.
	 */
	public function get_company($_args)
	{
		$search = [];
		$search['user_id'] = $this->user_id;
		$result = \lib\db\companies::search(null, $search);
		return $result;
	}
}
?>