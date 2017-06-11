<?php
namespace content_enter\main\tools;
use \lib\utility;
use \lib\debug;

trait go_to
{
	/**
	 * redirecto to url
	 *
	 * @param      <type>  $_url   The url
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function go_to($_url = null)
	{
		switch ($_url)
		{
			default:
				self::go_redirect($_url);
				break;
		}
	}


	/**
	 * set redirect url
	 *
	 * @param      <type>  $_url   The url
	 */
	public static function go_redirect($_url)
	{
		$redirect = (new \lib\redirector($_url))->redirect();
		debug::msg('direct', true);
	}
}
?>