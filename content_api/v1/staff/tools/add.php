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

		$team = utility::request('team');
		if(!$team)
		{
			logs::set('api:staff:team:notfound', null, $log_meta);
			debug::error(T_("Team not found"), 'user', 'permission');
			return false;
		}

		$team_id = \lib\db\teams::get_brand($team);

		if(isset($team_id['id']))
		{
			$team_id = $team_id['id'];
		}
		else
		{
			logs::set('api:staff:team:notfound:invalid', null, $log_meta);
			debug::error(T_("Team not found"), 'user', 'permission');
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

		$user_id = null;

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
				'displayname' => $name. ' '. $family,
			];

			$user_id = \lib\db\users::signup($signup);
		}

		if(!$user_id)
		{
			logs::set('api:staff:user_id:not:found:and:cannot:signup', $this->user_id, $log_meta);
			debug::error(T_("User id not found"), 'user', 'system');
			return false;
		}

		$postion     = utility::request('postion');

		if(mb_strlen($postion) > 250)
		{
			logs::set('api:staff:postion:max:length', $this->user_id, $log_meta);
			debug::error(T_("You can set the postion less than 250 character"), 'postion', 'arguments');
			return false;
		}

		$code        = utility::request('code');
		if($code && (mb_strlen($code) > 9 || !ctype_digit($code)))
		{
			logs::set('api:staff:code:max:length', $this->user_id, $log_meta);
			debug::error(T_("You can set the code less than 9 character and must ba integer"), 'code', 'arguments');
			return false;
		}

		// $telegram_id = utility::request('telegram_id');

		$full_time   = utility::request('full_time');
		if($full_time)
		{
			$full_time = 1;
		}
		else
		{
			$full_time = 0;
		}

		$remote      = utility::request('remote');
		if($remote)
		{
			$remote = 1;
		}
		else
		{
			$remote = 0;
		}

		$is_default  = utility::request('is_default');
		if($is_default)
		{
			$is_default = 1;
		}
		else
		{
			$is_default = 0;
		}

		$date_enter  = utility::request('date_enter');
		if($date_enter && \DateTime::createFromFormat('Y-m-d', $date_enter) === false)
		{
			logs::set('api:staff:date_enter:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid date of date enter"), 'date_enter', 'arguments');
			return false;
		}
		$date_exit   = utility::request('date_exit');
		if($date_exit && \DateTime::createFromFormat('Y-m-d', $date_exit) === false)
		{
			logs::set('api:staff:date_exit:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid date of date exit"), 'date_exit', 'arguments');
			return false;
		}

		$args               = [];
		$args['team_id'] = $team_id;
		$args['user_id']    = $user_id;
		$args['postion']    = $postion;
		$args['code']       = $code;
		$args['full_time']  = $full_time;
		$args['remote']     = $remote;
		$args['is_default'] = $is_default;
		$args['date_enter'] = $date_enter;
		$args['date_exit']  = $date_exit;

		if($_args['method'] === 'post')
		{
			\lib\db\userteams::insert($args);
		}
		elseif($_args['method'] === 'patch')
		{
			$id = utility::request('id');
			unset($args['team_id']);
			unset($args['user_id']);
			\lib\db\userteams::update($args, $id);
		}
		elseif ($_args['method'] === 'delete')
		{
			\lib\db\staffs::remove($args);
		}

		if(debug::$status)
		{
			debug::title(T_("Operation Complete"));

			if($_args['method'] === 'post')
			{
				debug::true(T_("Staff successfully added"));
			}
			elseif($_args['method'] === 'patch')
			{
				debug::true(T_("Staff successfully updated"));
			}
			else
			{
				debug::true(T_("Staff successfully removed"));
			}
		}

	}
}
?>