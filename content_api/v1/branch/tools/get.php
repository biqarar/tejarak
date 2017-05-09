<?php
namespace content_api\v1\branch\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait get
{
	/**
	 * Gets the branch.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The branch.
	 */
	public function get_list_branch($_args = [])
	{
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

		if(!utility::request('company'))
		{
			logs::set('api:branch:comany:brand:notfound', null, $log_meta);
			debug::error(T_("Comany not found"), 'comany', 'permission');
			return false;
		}

		$company_id = \lib\db\companies::get_brand(utility::request('company'));

		if(isset($company_id['id']))
		{
			$search               = [];
			$search['company_id'] = $company_id['id'];
			$result               = \lib\db\branchs::search(null, $search);
			return $result;
		}
	}


	/**
	 * Gets the branch.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The branch.
	 */
	public function get_branch($_args = [])
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
			logs::set('api:branch:user_id:notfound', null, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		$company = utility::request("company");
		$branch  = utility::request("branch");

		if(!$company)
		{
			logs::set('api:branch:comany:notfound', $this->user_id, $log_meta);
			debug::error(T_("Invalid comany"), 'company', 'permission');
			return false;
		}

		if(!$branch)
		{
			logs::set('api:branch:branch:notfound', $this->user_id, $log_meta);
			debug::error(T_("Invalid branch"), 'branch', 'permission');
			return false;
		}

		$result = \lib\db\branchs::get_by_brand($company, $branch);
		return $result;
	}
}
?>