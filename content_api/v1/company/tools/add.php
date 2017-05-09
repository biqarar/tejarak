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

		$args            = [];
		$args['creator']   = $this->user_id;
		$args['boss']      = $this->user_id;
		$args['technical'] = $this->user_id;
		$args['title']     = $title;
		$args['site']      = $site;

		if($_args['method'] === 'post')
		{
			$check_duplicate_title = ['creator' => $this->user_id, 'title' => $title, 'get_count' => true];
			$check = \lib\db\companies::search(null, $check_duplicate_title);
			if($check)
			{
				logs::set('api:company:duplocate:title', $this->user_id, $log_meta);
				debug::error(T_("Duplicate title of company"), 'title', 'arguments');
				return false;
			}
			$id = utility::request("id");

			if($id)
			{
				logs::set('api:company:method:post:set:id', $this->user_id, $log_meta);
				debug::error(T_("Can not set id in adding company"), 'id', 'access');
				return false;
			}

			$company_id = \lib\db\companies::insert($args);

			$branch               = [];
			$branch['company_id'] = $company_id;
			$branch['title']      = 'center';
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
			$id = utility::request("id");
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