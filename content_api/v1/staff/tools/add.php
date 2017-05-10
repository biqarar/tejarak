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
		$edit_mode = false;
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

		$title = utility::request('title');
		if(mb_strlen($title) > 500)
		{
			logs::set('api:staff:maxlength:title', $this->user_id, $log_meta);
			debug::error(T_("staff title must be less than 500 character"), 'title', 'arguments');
			return false;
		}

		$site = utility::request('site');
		if(mb_strlen($site) > 1000)
		{
			logs::set('api:staff:maxlength:site', $this->user_id, $log_meta);
			debug::error(T_("staff site must be less than 1000 character"), 'site', 'arguments');
			return false;
		}

		$brand = utility::request('brand');

		if(!$brand)
		{
			logs::set('api:staff:brand:not:sert', $this->user_id, $log_meta);
			debug::error(T_("Brand of staff can not be null"), 'brand', 'arguments');
			return false;
		}

		if(mb_strlen($brand) > 100)
		{
			logs::set('api:staff:maxlength:brand', $this->user_id, $log_meta);
			debug::error(T_("staff brand must be less than 500 character"), 'brand', 'arguments');
			return false;
		}

		if(!preg_match("/^[A-Za-z0-9]+$/", $brand))
		{
			logs::set('api:staff:invalid:brand', $this->user_id, $log_meta);
			debug::error(T_("Only [A-Za-z0-9] can use in staff brand"), 'brand', 'arguments');
			return false;
		}

		if(in_array($brand, \content_api\v1\home\tools\options::$brand_black_list))
		{
			logs::set('api:company:blocklist:brand', $this->user_id, $log_meta);
			debug::error(T_("Can not use this brand"), 'brand', 'arguments');
			return false;
		}

		$code        = utility::request('code');
		if(mb_strlen($code) > 9)
		{
			logs::set('api:staff:maxlength:code', $this->user_id, $log_meta);
			debug::error(T_("staff code must be less than 9 character"), 'code', 'arguments');
			return false;
		}

		$phone_1     = utility::request('phone_1');
		if(mb_strlen($phone_1) > 50)
		{
			logs::set('api:staff:maxlength:phone_1', $this->user_id, $log_meta);
			debug::error(T_("staff phone_1 must be less than 50 character"), 'phone_1', 'arguments');
			return false;
		}

		$phone_2     = utility::request('phone_2');
		if(mb_strlen($phone_2) > 50)
		{
			logs::set('api:staff:maxlength:phone_2', $this->user_id, $log_meta);
			debug::error(T_("staff phone_2 must be less than 50 character"), 'phone_2', 'arguments');
			return false;
		}

		$phone_3     = utility::request('phone_3');
		if(mb_strlen($phone_3) > 50)
		{
			logs::set('api:staff:maxlength:phone_3', $this->user_id, $log_meta);
			debug::error(T_("staff phone_3 must be less than 50 character"), 'phone_3', 'arguments');
			return false;
		}

		$fax     = utility::request('fax');
		if(mb_strlen($fax) > 50)
		{
			logs::set('api:staff:maxlength:fax', $this->user_id, $log_meta);
			debug::error(T_("staff fax must be less than 50 character"), 'fax', 'arguments');
			return false;
		}

		$email     = utility::request('email');
		if(mb_strlen($email) > 50)
		{
			logs::set('api:staff:maxlength:email', $this->user_id, $log_meta);
			debug::error(T_("staff email must be less than 50 character"), 'email', 'arguments');
			return false;
		}
		$post_code     = utility::request('post_code');
		if(mb_strlen($post_code) > 50)
		{
			logs::set('api:staff:maxlength:post_code', $this->user_id, $log_meta);
			debug::error(T_("staff post_code must be less than 50 character"), 'post_code', 'arguments');
			return false;
		}

		if(utility::request('full_time'))
		{
			$full_time = 1;
		}
		else
		{
			$full_time = 0;
		}

		if(utility::request('remote'))
		{
			$remote = 1;
		}
		else
		{
			$remote = 0;
		}

		if(utility::request('is_default'))
		{
			$is_default = 1;
		}
		else
		{
			$is_default = 0;
		}

		// $boss        = utility::request('boss');
		// $technical   = utility::request('technical');
		$address     = utility::request('address');
		// $telegram_id = utility::request('telegram_id');

		$args               = [];
		$args['creator']    = $this->user_id;
		$args['boss']       = $this->user_id;
		$args['company_id'] = $company_id;
		$args['technical']  = $this->user_id;
		$args['title']      = $title;
		$args['site']       = $site;
		$args['brand']      = $brand;
		$args['address']    = $address;
		$args['code']       = $code;
		$args['phone_1']    = $phone_1;
		$args['phone_2']    = $phone_2;
		$args['phone_3']    = $phone_3;
		$args['fax']        = $fax;
		$args['email']      = $email;
		$args['post_code']  = $post_code;
		$args['full_time']  = $full_time;
		$args['remote']     = $remote;
		$args['is_default'] = $is_default;

		if($_args['method'] === 'post')
		{
			$check_duplicate_brand_in_company = ['brand' => $brand, 'company_id' => $company_id, 'get_count' => true];
			$check = \lib\db\staffs::search(null, $check_duplicate_brand_in_company);
			if($check)
			{
				logs::set('api:staff:duplocate:brand:in:company', $this->user_id, $log_meta);
				debug::error(T_("Duplicate brand of staff"), 'brand', 'arguments');
				return false;
			}
			$id = utility::request("id");

			if($id)
			{
				logs::set('api:staff:method:post:set:id', $this->user_id, $log_meta);
				debug::error(T_("Can not set id in adding staff"), 'id', 'access');
				return false;
			}

			\lib\db\staffs::insert($args);
		}
		elseif ($_args['method'] === 'patch')
		{
			$edit_mode = true;
			$staff = utility::request("staff");

			if(!$staff)
			{
				logs::set('api:staff:method:put:staff:not:set', $this->user_id, $log_meta);
				debug::error(T_("staff not set"), 'staff', 'permission');
				return false;
			}

			$find_staff_id = \lib\db\staffs::search(null, ['company_id' => $company_id, 'brand' => $staff]);
			if(isset($find_staff_id[0]['id']))
			{
				$id = $find_staff_id[0]['id'];
			}
			else
			{
				logs::set('api:staff:method:put:staff:not:found', $this->user_id, $log_meta);
				debug::error(T_("staff not found"), 'staff', 'permission');
				return false;
			}

			$update = [];
			foreach ($args as $key => $value)
			{
				if(utility::isset_request($key))
				{
					$update[$key] = $value;
				}
			}
			if(!empty($update))
			{
				\lib\db\staffs::update($update, $id);
			}
		}

		if(debug::$status)
		{
			debug::title(T_("Operation Complete"));
			if($edit_mode)
			{
				debug::true("staff edited");
			}
			else
			{
				debug::true("staff added");
			}
		}
		else
		{
			if($edit_mode)
			{
				debug::error(T_("Error in editing staff"));
			}
			else
			{
				debug::error(T_("Error in adding staff"));
			}
		}

	}
}
?>