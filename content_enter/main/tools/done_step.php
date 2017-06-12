<?php
namespace content_enter\main\tools;
use \lib\utility;
use \lib\debug;

trait done_step
{

	/**
	 * set redirect url
	 *
	 * @param      <type>  $_url   The url
	 */
	public static function done_step($_module)
	{
		switch ($_module)
		{
			default:
				if(self::get_step_session($_module))
				{
					return true;
				}

				break;
		}
		return false;
	}
}
?>