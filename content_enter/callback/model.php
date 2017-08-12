<?php
namespace content_enter\callback;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

class model extends \content_enter\main\model
{
	public function kavenegar()
	{

		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'get'  => utility::get(),
				'post' => utility::post(),
			],
		];

		logs::set('enter:callback:sms:resieve', null, $log_meta);

		$message = utility::post('message');
		$message = trim($message);
		if(!$message || mb_strlen($message) < 1)
		{
			logs::set('enter:callback:message:empty', null, $log_meta);
			debug::error(T_("Message is empty"));
			return false;
		}

		$mobile = utility::post('from');

		if($mobile)
		{
			$mobile = \lib\utility\filter::mobile($mobile);
		}

		if(!$mobile)
		{
			logs::set('enter:callback:from:not:set', null, $log_meta);
			debug::error(T_("Mobile not set"));
			return false;
		}

		$user_data = \lib\db\users::get_by_mobile($mobile);
		if(!$user_data || !isset($user_data['id']))
		{
			logs::set('enter:callback:mobile:not:found', null, $log_meta);
			debug::error(T_("Mobile not found"));
			return false;
		}

		$user_id = $user_data['id'];

		$find_log =
		[
			'caller'     => 'enter:get:sms:from:user',
			'user_id'    => $user_id,
			'log_data'   => $message,
			'log_status' => 'enable',
		];

		$find_log = logs::get($find_log);

		if(!$find_log || !is_array($find_log) || count($find_log) === 0)
		{
			logs::set('enter:callback:sms:resieve:log:not:found', $user_id, $log_meta);
			debug::error(T_("Log not found"));
			return false;
		}

		if(count($find_log) > 1)
		{
			logs::set('enter:callback:sms:more:than:one:log:found', $user_id, $log_meta);
			foreach ($find_log as $key => $value)
			{
				if(isset($value['id']))
				{
					logs::update(['log_status' => 'expire'], $value);
				}
			}
			debug::error(T_("More than one log found"));
			return false;
		}

		if(count($find_log) === 1)
		{
			$find_log = $find_log[0];
			if(isset($find_log['id']))
			{
				logs::update(['log_status' => 'deliver'], $find_log['id']);
				debug::true(T_("OK"));
				return true;
			}
		}

		// {
		// 	"get":"service=kavenegar&type=recieve&uid=201700001",
		// 	"post":
		// 		{
		// 			"messageid":"308404060",
		// 			"from":"09109610612",
		// 			"to":"10006660066600",
		// 			"message":"Salamq"
		// 		}
		// 	}
	}
}
?>