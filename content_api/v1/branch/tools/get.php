<?php
namespace content_api\v1\branch\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait get
{

	/**
	 * ready data of company to load in api
	 *
	 * @param      <type>  $_data  The data
	 */
	public function ready_branch($_data, $_options = [])
	{
		$default_options =
		[
			'check_is_my_company' => true,
		];

		if(!is_array($_options))
		{
			$_options = [];
		}

		$_options = array_merge($default_options, $_options);

		$result = [];
		foreach ($_data as $key => $value)
		{
			switch ($key)
			{
				case 'company_id':
				case 'code':
					$result[$key] = (int) $value;
					break;
				case 'brand':
				case 'title':
				case 'site':
				case 'address':
				case 'phone_1':
				case 'phone_2':
				case 'phone_3':
				case 'fax':
				case 'email':
				case 'post_code':
				case 'status':
					$result[$key] = (string) $value;
					break;


				case 'full_time':
				case 'remote':
				case 'is_default':
					if($value)
					{
						$result[$key] = true;
					}
					else
					{
						$result[$key] = false;
					}
					break;

				case 'boss':
					if($_options['check_is_my_company'])
					{
						if(intval($value) === intval($this->user_id))
						{
							// no problem
						}
						else
						{
							return false;
						}
					}
					break;
				case 'createdate':
				case 'date_modified':
				case 'desc':
				case 'meta':
				default:
					continue;
					break;
			}
		}
		return $result;
	}


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
			$temp = [];
			foreach ($result as $key => $value)
			{
				$check = $this->ready_branch($value);
				if($check)
				{
					$temp[] =  $check;
				}
			}
			return $temp;
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
		$result = $this->ready_branch($result);
		return $result;
	}
}
?>