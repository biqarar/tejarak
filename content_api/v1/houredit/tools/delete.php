<?php
namespace content_api\v1\houredit\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;
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
			return false;
		}

		$id = utility::request("id");
		$id = \lib\utility\shortURL::decode($id);

		if(!$id)
		{
			logs::set('api:houredit:delete:id:not:set', $this->user_id, $log_meta);
			debug::error(T_("houredit id not set"), 'id', 'arguments');
			return false;
		}

		$result = \lib\db\hourrequests::access_hourrequest_id($id, $this->user_id, ['action' => 'delete']);

		if(!$result)
		{
			logs::set('api:houredit:delete:access:denide', $this->user_id, $log_meta);
			debug::error(T_("Can not access to delete this request"), 'houredit', 'permission');
			return false;
		}


		\lib\db\hourrequests::update(['status' => 'deleted'], $id);

		if(debug::$status)
		{
			debug::title(T_("Operation complete"));
			debug::warn(T_("Your request was deleted"));
		}
		return;
	}
}
?>