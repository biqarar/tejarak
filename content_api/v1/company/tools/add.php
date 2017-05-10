<?php
namespace content_api\v1\company\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;
trait add
{


	public function add_company($_args = [])
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
			logs::set('api:company:user_id:notfound', null, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		$title = utility::request('title');

		if(mb_strlen($title) > 500)
		{
			logs::set('api:company:maxlength:title', $this->user_id, $log_meta);
			debug::error(T_("Company title must be less than 500 character"), 'title', 'arguments');
			return false;
		}

		$site = utility::request('site');
		if(mb_strlen($site) > 1000)
		{
			logs::set('api:company:maxlength:site', $this->user_id, $log_meta);
			debug::error(T_("Company site must be less than 1000 character"), 'site', 'arguments');
			return false;
		}

		$brand = utility::request('brand');

		if(!$brand)
		{
			logs::set('api:company:brand:not:sert', $this->user_id, $log_meta);
			debug::error(T_("Brand of company can not be null"), 'brand', 'arguments');
			return false;
		}

		if(mb_strlen($brand) > 100)
		{
			logs::set('api:company:maxlength:brand', $this->user_id, $log_meta);
			debug::error(T_("Company brand must be less than 500 character"), 'brand', 'arguments');
			return false;
		}


		if(mb_strlen($brand) < 5)
		{
			logs::set('api:company:minlength:brand', $this->user_id, $log_meta);
			debug::error(T_("Company brand must be larger than 5 character"), 'brand', 'arguments');
			return false;
		}

		if(in_array($brand, \content_api\v1\home\tools\options::$brand_black_list))
		{
			logs::set('api:company:blocklist:brand', $this->user_id, $log_meta);
			debug::error(T_("Can not use this brand"), 'brand', 'arguments');
			return false;
		}

		if(!preg_match("/^[A-Za-z0-9]+$/", $brand))
		{
			logs::set('api:company:invalid:brand', $this->user_id, $log_meta);
			debug::error(T_("Only [A-Za-z0-9] can use in comany brand"), 'brand', 'arguments');
			return false;
		}

		$id = null;
		if($_args['method'] === 'patch')
		{
			$temp_company = \lib\db\companies::get_brand(utility::request('company'));
			if(isset($temp_company['id']))
			{
				$id = $temp_company['id'];
			}
		}

		$check_duplicate_title = ['brand' => $brand];
		$check = \lib\db\companies::search(null, $check_duplicate_title);
		if($check)
		{
			if($_args['method'] === 'post')
			{
				logs::set('api:company:duplocate:brand', $this->user_id, $log_meta);
				debug::error(T_("Duplicate brand of company"), 'brand', 'arguments');
				return false;
			}
			else
			{
				if(isset($check[0]['id']) && intval($check[0]['id']) === intval($id))
				{
					// not problem
				}
				else
				{
					logs::set('api:company:duplocate:brand', $this->user_id, $log_meta);
					debug::error(T_("Duplicate brand of company"), 'brand', 'arguments');
					return false;
				}
			}
		}


		$args              = [];
		$args['creator']   = $this->user_id;
		$args['boss']      = $this->user_id;
		$args['technical'] = $this->user_id;
		$args['title']     = $title;
		$args['brand']     = $brand;
		$args['site']      = $site;

		if($_args['method'] === 'post')
		{

			if($id)
			{
				logs::set('api:company:method:post:set:id', $this->user_id, $log_meta);
				debug::error(T_("Can not set id in adding company"), 'id', 'access');
				return false;
			}

			$company_id = \lib\db\companies::insert($args);

			$branch               = [];
			$branch['company_id'] = $company_id;
			$branch['brand']      = $brand;
			$branch['title']      = 'centeral';
			$branch['site']       = $site;
			$branch['creator']    = $this->user_id;
			$branch['boss']       = $this->user_id;
			$branch['technical']  = $this->user_id;
			$branch['is_default'] = 1;

			\lib\db\branchs::insert($branch);
		}
		elseif ($_args['method'] === 'patch')
		{
			$edit_mode = true;

			if(!$id || !is_numeric($id))
			{
				logs::set('api:company:method:put:id:not:set', $this->user_id, $log_meta);
				debug::error(T_("Id of Comany not found"), 'id', 'permission');
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
				\lib\db\companies::update($update, $id);
			}
		}
		elseif ($_args['method'] === 'pathc')
		{

		}

		if(debug::$status)
		{
			debug::title(T_("Operation Complete"));
			if($edit_mode)
			{
				debug::true("Comany edited");
			}
			else
			{
				debug::true("Comany added");
			}
		}
		else
		{
			if($edit_mode)
			{
				debug::error(T_("Error in editing company"));
			}
			else
			{
				debug::error(T_("Error in adding company"));
			}
		}

	}
}
?>