<?php
namespace content_api\v1\houredit\tools;


trait delete
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
	public function hourrequest_delete($_args = [])
	{
		// \dash\notif::title(T_("Operation Faild"));
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => \dash\utility::request(),
			]
		];

		if(!$this->user_id)
		{
			return false;
		}

		$id = \dash\utility::request("id");
		$id = \dash\coding::decode($id);

		if(!$id)
		{
			\dash\db\logs::set('api:houredit:delete:id:not:set', $this->user_id, $log_meta);
			\dash\notif::error(T_("houredit id not set"), 'id', 'arguments');
			return false;
		}

		$result = \lib\db\hourrequests::access_hourrequest_id($id, $this->user_id, ['action' => 'delete']);

		if(!$result)
		{
			\dash\db\logs::set('api:houredit:delete:access:denide', $this->user_id, $log_meta);
			\dash\notif::error(T_("Can not access to delete this request"), 'houredit', 'permission');
			return false;
		}


		\lib\db\hourrequests::update(['status' => 'deleted'], $id);

		if(\lib\engine\process::status())
		{
			// \dash\notif::title(T_("Operation complete"));
			\dash\notif::warn(T_("Your request was deleted"));
		}
		return;
	}
}
?>