<?php
namespace content_api\v1\gateway\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;
trait add
{

	/**
	 * Adds a gateway.
	 *
	 * @param      array    $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function add_gateway($_args = [])
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
			logs::set('api:gateway:user_id:notfound', null, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		$team = utility::request('team');

		$load_team = $this->get_team();

		if(isset($load_team['id']))
		{
			$team_id = $load_team['id'];
		}
		else
		{
			logs::set('api:gateway:access:to:load:team', $this->user_id, $log_meta);
			debug::error(T_("Comapany not found"), 'team', 'permission');
			return false;
		}

		$load_branch = $this->get_branch();

		if(!debug::$status)
		{
			return false;
		}

		if(isset($load_branch['id']))
		{
			$branch_id = $load_branch['id'];
		}
		else
		{
			logs::set('api:gateway:access:to:load:branch', $this->user_id, $log_meta);
			debug::error(T_("Branch not found"), 'team', 'permission');
			return false;
		}

		$title = utility::request('title');
		if(!$title)
		{
			logs::set('api:gateway:title:is:null', $this->user_id, $log_meta);
			debug::error(T_("Title Can not be null"), 'title', 'arguments');
			return false;
		}

		if(mb_strlen($title) > 255)
		{
			logs::set('api:gateway:title:invalid', $this->user_id, $log_meta);
			debug::error(T_("Title must be less than 255 character"), 'title', 'arguments');
			return false;
		}

		$search =
		[
			'team_id' => $team_id,
			'title'      => $title,
			'branch_id'  => $branch_id,
		];

		$check = \lib\db\getwaies::search(null, $search);

		if($check)
		{
			if($_args['method'] === 'post')
			{
				logs::set('api:gateway:title:duplicate', $this->user_id, $log_meta);
				debug::error(T_("Duplicate title of gateway"), 'title', 'arguments');
				return false;
			}
			else
			{

			}
		}

		$cat = utility::request('cat');
		if(mb_strlen($cat) > 255)
		{
			logs::set('api:gateway:cat:invalid', $this->user_id, $log_meta);
			debug::error(T_("Cat  must be less than 255 character"), 'cat', 'arguments');
			return false;
		}
		$code = utility::request('code');
		if($code && !is_numeric($code))
		{
			logs::set('api:gateway:code:invalid', $this->user_id, $log_meta);
			debug::error(T_("Code must be number"), 'code', 'arguments');
			return false;
		}
		$ip = utility::request('ip');
		if($ip && !is_numeric($ip))
		{
			logs::set('api:gateway:ip:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid ip"), 'ip', 'arguments');
			return false;
		}
		$status = utility::request('status');
		if(!in_array($status, ['enable', 'disable']))
		{
			logs::set('api:gateway:status:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid status"), 'status', 'arguments');
			return false;
		}

		$desc               = utility::request('desc');

		$args               = [];
		$args['title']      = $title;
		$args['cat']        = $cat;
		$args['code']       = $code;
		$args['ip']         = $ip;
		$args['status']     = $status;
		$args['desc']       = $desc;
		$args['team_id'] = $team_id;
		$args['user_id']    = $this->user_id;
		$args['branch_id']  = $branch_id;
		if($_args['method'] === 'post')
		{
			\lib\db\getwaies::insert($args);
		}
		elseif($_args['method'] === 'patch')
		{
			$id = utility::request('id');
			unset($args['team_id']);
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
				debug::true(T_("gateway successfuly added"));
			}
			elseif($_args['method'] === 'patch')
			{
				debug::true(T_("gateway updated"));
			}
			else
			{
				debug::true(T_("gateway removed"));
			}
		}
	}
}
?>