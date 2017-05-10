<?php
namespace content_api\v1\staff\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;
trait add
{


	/**
	 * Adds a staff.
	 *
	 * @param      array    $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function add_staff($_args = [])
	{
		$delete_mode = false;
		$default_args =
		[
			'method' => 'post'
		];

		if(!is_array($_args))
		{
			$_args = [];
		}

		$_args = array_merge($default_args, $_args);

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
			logs::set('api:staff:user_id:notfound', null, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		$company = utility::request('company');
		if(!$company)
		{
			logs::set('api:staff:company:notfound', null, $log_meta);
			debug::error(T_("Company not found"), 'user', 'permission');
			return false;
		}

		$company_id = \lib\db\companies::get_brand($company);

		if(isset($company_id['id']))
		{
			$company_id = $company_id['id'];
		}
		else
		{
			logs::set('api:staff:company:notfound:invalid', null, $log_meta);
			debug::error(T_("Company not found"), 'user', 'permission');
			return false;
		}

		$mobile = utility::request("mobile");
		$mobile = \lib\utility\filter::mobile($mobile);
		if(!$mobile)
		{
			logs::set('api:staff:mobile:not:set', $this->user_id, $log_meta);
			debug::error(T_("Invalid mobile number"), 'mobile', 'arguments');
			return false;
		}

		$name = utility::request("name");
		if(mb_strlen($name) > 50)
		{
			logs::set('api:staff:name:max:length', $this->user_id, $log_meta);
			debug::error(T_("You can set the name less than 50 character"), 'name', 'arguments');
			return false;
		}

		$family = utility::request("family");
		if(mb_strlen($family) > 50)
		{
			logs::set('api:staff:family:max:length', $this->user_id, $log_meta);
			debug::error(T_("You can set the family less than 50 character"), 'family', 'arguments');
			return false;
		}

		$check_user_exist = \lib\db\users::get_by_mobile($mobile);
		if(isset($check_user_exist['id']))
		{
			$user_id = $check_user_exist['id'];
		}
		else
		{
			$signup =
			[
				'mobile'      => $mobile,
				'password'    => \lib\utility::hasher($mobile),
				'displayname' => $name . ' '. $family,
			];

			$user_id = \lib\db\users::signup($signup);
		}

		$args               = [];
		$args['company_id'] = $company_id;
		$args['user_id']    = $user_id;

		if($_args['method'] === 'post')
		{
			\lib\db\usercompanies::insert($args);
		}

		elseif ($_args['method'] === 'delete')
		{
			\lib\db\staffs::remove($args);
		}

		if(debug::$status)
		{
			debug::title(T_("Operation Complete"));
			if($delete_mode)
			{
				debug::true("staff removed");
			}
			else
			{
				debug::true("staff added");
			}
		}
		else
		{
			if($delete_mode)
			{
				debug::error(T_("Error in removing staff"));
			}
			else
			{
				debug::error(T_("Error in adding staff"));
			}
		}

	}
}
?>