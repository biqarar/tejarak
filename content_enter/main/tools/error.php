<?php
namespace content_enter\main\tools;
use \lib\utility;
use \lib\debug;

trait error
{

	/**
	 * set redirect url
	 *
	 * @param      <type>  $_url   The url
	 */
	public static function error_page($_module)
	{
		switch ($_module)
		{
			default:
				\lib\error::page($_module);
				break;
		}
	}
}