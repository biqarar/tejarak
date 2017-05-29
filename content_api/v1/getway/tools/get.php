<?php
namespace content_api\v1\getway\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait get
{
	/**
	 * Gets the getway.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The getway.
	 */
	public function get_list_getway($_args = [])
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
			logs::set('api:getway:comany:brand:notfound', null, $log_meta);
			debug::error(T_("Comany not found"), 'comany', 'permission');
			return false;
		}

		$company_id = \lib\db\companies::get_brand(utility::request('company'));

		if(isset($company_id['id']))
		{
			$where               = [];
			$where['company_id'] = $company_id['id'];
			$result               = \lib\db\usercompanies::get($where);
			return $result;
		}
	}


	/**
	 * Gets the getway.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The getway.
	 */
	public function get_getway($_args = [])
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
			logs::set('api:getway:user_id:notfound', null, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		$company = utility::request("company");
		$getway  = utility::request("getway");

		if(!$company)
		{
			logs::set('api:getway:comany:notfound', $this->user_id, $log_meta);
			debug::error(T_("Invalid comany"), 'company', 'permission');
			return false;
		}

		if(!$getway)
		{
			logs::set('api:getway:getway:notfound', $this->user_id, $log_meta);
			debug::error(T_("Invalid getway"), 'getway', 'permission');
			return false;
		}

		// $result = \lib\db\getways::get_by_brand($company, $getway);
		// return $result;
	}

}
?>