<?php
namespace content_api\v1\getway\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;
trait add
{


	/**
	 * Adds a getway.
	 *
	 * @param      array    $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function add_getway($_args = [])
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
			logs::set('api:getway:user_id:notfound', null, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}


		$company = utility::request('company');
		if(!$company)
		{
			logs::set('api:getway:company:notfound', null, $log_meta);
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
			logs::set('api:getway:company:notfound:invalid', null, $log_meta);
			debug::error(T_("Company not found"), 'user', 'permission');
			return false;
		}

		$title = utility::request('title');
		if(mb_strlen($title) > 255)
		{
			logs::set('api:getway:title:invalid', $this->user_id, $log_meta);
			debug::error(T_("Title must be less than 255 character"), 'title', 'arguments');
			return false;
		}
		$cat = utility::request('cat');
		if(mb_strlen($cat) > 255)
		{
			logs::set('api:getway:cat:invalid', $this->user_id, $log_meta);
			debug::error(T_("Cat  must be less than 255 character"), 'cat', 'arguments');
			return false;
		}
		$code = utility::request('code');
		if(!is_numeric($code))
		{
			logs::set('api:getway:code:invalid', $this->user_id, $log_meta);
			debug::error(T_("Code must be number"), 'code', 'arguments');
			return false;
		}
		$ip = utility::request('ip');
		if(!is_numeric($ip))
		{
			logs::set('api:getway:ip:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid ip"), 'ip', 'arguments');
			return false;
		}
		$status = utility::request('status');
		if(!in_array($status, ['enable', 'disable']))
		{
			logs::set('api:getway:status:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid status"), 'status', 'arguments');
			return false;
		}

		$desc = utility::request('desc');
		$args               = [];
		$args['title']  = $title;
		$args['cat']    = $cat;
		$args['code']   = $code;
		$args['ip']     = $ip;
		$args['status'] = $status;
		$args['desc']   = $desc;
		$args['company_id'] = $company_id;
		$args['user_id']    = $this->user_id;


		if($_args['method'] === 'post')
		{
			\lib\db\getwaies::insert($args);
		}
		elseif($_args['method'] === 'patch')
		{
			$id = utility::request('id');
			unset($args['company_id']);
			unset($args['user_id']);
			\lib\db\getwaies::update($args, $id);
		}
		elseif ($_args['method'] === 'delete')
		{
			\lib\db\getwaies::remove($args);
		}

		if(debug::$status)
		{
			debug::title(T_("Operation Complete"));

			if($_args['method'] === 'post')
			{
				debug::true(T_("getway added"));
			}
			elseif($_args['method'] === 'patch')
			{
				debug::true(T_("getway update"));
			}
			else
			{
				debug::true(T_("getway removed"));
			}
		}
		else
		{

			if($_args['method'] === 'post')
			{
				debug::error(T_("Error in adding getway"));
			}
			elseif($_args['method'] === 'patch')
			{
				debug::error(T_("Error in updating getway"));
			}
			else
			{
				debug::error(T_("Error in removing getway"));
			}
		}

	}
}
?>