<?php
namespace content_api\v1\houredit\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;
trait add
{

	/**
	 * Adds houredit.
	 * add member time
	 * start or end of time save on this function and
	 * minus and plus time
	 * @param      array    $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function add_houredit($_args = [])
	{

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
			logs::set('api:houredit:user_id:not:set', null, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		$id         = utility::request('id'); // '3Fh'
		$start_date = utility\human::number(utility::request('start_date'), 'en'); // '۱۳۹۶-۰۴-۰۷'
		$start_time = utility\human::number(utility::request('start_time'), 'en'); // '۱۲:۲۸:۰۰'
		$end_date   = utility\human::number(utility::request('end_date'), 'en'); // ''
		$end_time   = utility\human::number(utility::request('end_time'), 'en'); // ''
		$desc       = utility::request('desc'); // ''

		$id = utility\shortURL::decode($id);
		if(!$id)
		{
			logs::set('api:houredit:id:not:set', null, $log_meta);
			debug::error(T_("Id not set"), 'id', 'arguments');
			return false;
		}

		if(!$start_date)
		{
			logs::set('api:houredit:start_date:not:set', null, $log_meta);
			debug::error(T_("Start date not set"), 'start_date', 'arguments');
			return false;
		}

		if(!$start_time)
		{
			logs::set('api:houredit:start_time:not:set', null, $log_meta);
			debug::error(T_("Start time not set"), 'start_time', 'arguments');
			return false;
		}

		if(!$end_date)
		{
			logs::set('api:houredit:end_date:not:set', null, $log_meta);
			debug::error(T_("end date not set"), 'end_date', 'arguments');
			return false;
		}

		if(!$end_time)
		{
			logs::set('api:houredit:end_time:not:set', null, $log_meta);
			debug::error(T_("end time not set"), 'end_time', 'arguments');
			return false;
		}

		if($desc && mb_strlen($desc) > 500)
		{
			logs::set('api:houredit:desc:max:length', null, $log_meta);
			debug::error(T_("You must be set less than 500 character in description field"), 'desc', 'arguments');
			return false;
		}

		// load hour data
		$hour_detail = \lib\db\hours::access_hours_id($id, $this->user_id, ['action' => 'view']);

		// check the hour exist
		if(isset($hour_detail['id']))
		{
			$hour_id = $hour_detail['id'];
		}
		else
		{
			logs::set('api:houredit:hour:notfound:invalid', null, $log_meta);
			debug::error(T_("Can not access to set time of this hour"), 'hour', 'permission');
			return false;
		}

		$update_mode = false;
		// get this hour id is set old or no
		$check_exist = \lib\db\hourrequests::get(['hour_id' => $id, 'limit' => 1]);
		if($check_exist)
		{
			if(isset($check_exist['id']))
			{
				$update_mode = true;
			}
			else
			{
				logs::set('api:houredit:hour:duplicate:insert:hour_id', null, $log_meta);
				debug::error(T_("You was already set this request"), 'id', 'arguments');
				return false;
			}
		}

		$args            = [];
		$args['hour_id'] = $id;
		$args['date']    = $start_date;
		$args['start']   = $start_time;
		$args['end']     = $end_time;
		$args['enddate'] = $end_date;
		$args['desc']    = $desc;
		$args['creator'] = $this->user_id;

		if($_args['method'] === 'post' && !$update_mode)
		{
			$houredit_id = \lib\db\hourrequests::insert($args);
		}
		elseif($update_mode)
		{
			unset($args['hour_id']);
			unset($args['creator']);
			$houredit_id = \lib\db\hourrequests::update($args, $check_exist['id']);
		}
		else
		{
			logs::set('api:houredit:method:error', null, $log_meta);
			debug::error(T_("Syste error"), 'system', 'error');
			return false;
		}

		if(debug::$status)
		{
			debug::title(T_("Operation complete"));
			if($update_mode)
			{
				debug::true(T_("Your request updated"));
			}
			else
			{
				debug::true(T_("Your request sended"));
			}
		}
	}
}
?>