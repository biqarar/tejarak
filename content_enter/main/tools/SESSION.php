<?php
namespace content_enter\main\tools;
use \lib\utility;
use \lib\debug;

trait SESSION
{
	/**
	* Clean session
	*
	*/
	public static function clean_session()
	{
		$_SESSION['enter'] = [];
	}


	/**
	 * Sets the enter session.
	 *
	 * @param      <type>  $_key    The key
	 * @param      <type>  $_value  The value
	 */
	public static function set_enter_session($_key, $_value)
	{
		self::set_session('enter', $_key, $_value);
	}


	/**
	 * Gets the enter session.
	 *
	 * @param      <type>  $_key   The key
	 */
	public static function get_enter_session($_key)
	{
		return self::get_session('enter', $_key);
	}


	/**
	 * Gets the session.
	 *
	 * @param      <type>  $_index  The index
	 * @param      <type>  $_key    The key
	 *
	 * @return     <type>  The session.
	 */
	private static function get_session($_index, $_key)
	{
		if(isset($_SESSION[$_index]))
		{
			if(array_key_exists($_key, $_SESSION[$_index]))
			{
				return $_SESSION[$_index][$_key];
			}
		}
		return null;
	}


	/**
	 * Sets the session.
	 *
	 * @param      <type>  $_index  The index
	 * @param      <type>  $_key    The key
	 * @param      <type>  $_value  The value
	 */
	private static function set_session($_index, $_key, $_value)
	{
		if(!isset($_SESSION[$_index]))
		{
			$_SESSION[$_index] = [];
		}
		$_SESSION[$_index][$_key] = $_value;
	}
}
?>