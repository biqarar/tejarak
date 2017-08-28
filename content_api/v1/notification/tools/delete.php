<?php
namespace content_api\v1\notification\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait delete
{

	/**
	 * Gets the notification.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The notification.
	 */
	public function delete_notification($_args = [])
	{
		if(!$this->user_id)
		{
			return false;
		}

		debug::title(T_("Operation Faild"));
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => utility::request(),
			]
		];

		$id = utility::request("id");
		$id = \lib\utility\shortURL::decode($id);
		if(!$id)
		{
			logs::set('api:notification:delete:id:not:set', $this->user_id, $log_meta);
			debug::error(T_("Id not set"), 'id', 'arguments');
			return false;
		}

		$notification_details = \lib\db\notifications::access_notification_id($id, $this->user_id, ['action' => 'delete']);
		if(!$notification_details || !isset($notification_details['id']))
		{
			logs::set('api:notification:delete:permission:denide', $this->user_id, $log_meta);
			debug::error(T_("Can not access to delete this notification"), 'id', 'permission');
			return false;
		}

		if(\lib\db\notifications::update(['status' => 'deleted'], $notification_details['id']))
		{
			$log_meta['meta']['notification'] = $notification_details;
			logs::set('api:notification:delete:notification:complete', $this->user_id, $log_meta);
			debug::title(T_("Operation Complete"));
			debug::warn(T_("The notification was deleted"));
		}

	}
}
?>