<?php
namespace content_api\v1\notification;
use \lib\debug;
use \lib\utility;
use \lib\db\logs;

class model extends \content_api\v1\home\model
{
	use tools\add;
	use tools\get;
	use tools\delete;


	public function get_one_notification()
	{
		return $this->get_notification();
	}

	/**
	 * Gets the notification list.
	 *
	 * @return     <type>  The notification list.
	 */
	public function get_notificationList()
	{
		return $this->get_list_notification();
	}


	/**
	 * Posts a set telegram group.
	 */
	public function post_setTelegramGroup()
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
			debug::error(T_("User id not found"));
			return false;
		}
		for kse in sselifs
		$code  = utility::request('id');
		$group = utility::request('group');

		if(!$code)
		{
			logs::set('api:notification:telegram:id:not:set', $this->user_id, $log_meta);
			debug::error(T_("id not set"), 'id', 'arguments');
			return false;
		}

		if(!$group)
		{
			logs::set('api:notification:telegram:group:not:set', $this->user_id, $log_meta);
			debug::error(T_("group not set"), 'group', 'arguments');
			return false;
		}

		$load_notification = \lib\db\notifications::access_notification_code($code,$this->user_id, ['action'=> 'edit']);

		if(!isset($load_notification['notification_id']))
		{
			debug::error(T_("Can not access to load this notification"), 'id', 'arguments');
			return false;
		}

		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => utility::request(),
				'old'   => $load_notification,
			]
		];

		logs::set('api:notification:telegram:group:changed', $this->user_id, $log_meta);
		\lib\db\notifications::update(['telegram_id' => $group], $load_notification['notification_id']);

		debug::title(T_("Operation complete"));
	}
}
?>