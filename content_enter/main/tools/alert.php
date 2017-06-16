<?php
namespace content_enter\main\tools;

trait alert
{
	/**
	 * Opens a alert.
	 *
	 * @param      <type>  $_module  The module
	 */
	public static function get_alert()
	{
		return self::get_session('alert', 'alert');
	}


	/**
	 * disable all alert page and set only this module is true
	 *
	 * @param      <type>  $_module  The module
	 */
	public static function set_alert($_msg)
	{
		self::set_session('alert', 'alert', $_msg);
	}
}
?>