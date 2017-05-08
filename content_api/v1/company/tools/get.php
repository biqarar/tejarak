<?php
namespace content_api\v1\company\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait get
{
	/**
	 * Gets the company.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The company.
	 */
	public function get_list_company($_args = [])
	{
		if(!$this->user_id)
		{
			return false;
		}
		$search = [];
		$search['creator'] = $this->user_id;
		$result = \lib\db\companies::search(null, $search);

		return $result;
	}


	/**
	 * Gets the company.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The company.
	 */
	public function get_company($_args = [])
	{
		debug::title(T_("Operation Faild"));
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => utility::request(),
			]
		];

		$id = utility::request("id");

		if(!$id || !is_numeric($id))
		{
			debug::error(T_("Invalid comany id"), 'id', 'permission');
		}

		if(!$this->user_id)
		{
			return false;
		}


		$result = \lib\db\companies::get($id);

		return $result;
	}
}
?>