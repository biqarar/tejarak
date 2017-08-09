<?php
namespace lib\db\teams;
trait report
{
	/**
	 * { function_description }
	 *
	 * @param      <type>  $_team_id  The team identifier
	 */
	public static function timed_auto_report($_team_id)
	{
		\lib\utility\telegram::sendMessage(33263188, json_encode((array) func_get_args(), JSON_UNESCAPED_UNICODE));
	}
}