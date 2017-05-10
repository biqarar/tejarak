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
		$search['boss'] = $this->user_id;
		$search['status'] = ['<>', "'deleted'"];
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

		if(!$this->user_id)
		{
			return false;
		}

		$company = utility::request("company");

		if(!$company)
		{
			logs::set('api:company:not:found', $this->user_id, $log_meta);
			debug::error(T_("Invalid comany brand"), 'company', 'permission');
			return false;
		}


		debug::title(T_("Operation complete"));
		$result = \lib\db\companies::get_brand($company);

		return $result;
	}
}
?>