<?php
namespace content_enter\main\tools;
use \lib\utility;
use \lib\debug;

trait check_input
{
	/**
	 * check valid route page
	 *
	 * @param      <type>  $_url   The url
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function check_valid_route($_url)
	{
		$return = false;
		switch ($_url)
		{
			// in step mobile (first step)
			case 'mobile':
				$return = true;
				break;

			default:
				# code...
				break;
		}
		return $return;
	}


	/**
	 * cehck input in every step
	 *
	 * @param      <type>  $_url   The url
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function check_input($_url = null)
	{

		$return = false;
		switch ($_url)
		{
			// in step mobile (first step)
			case 'mobile':
				// just when only posted 1 item and this item is mobile can continue
				if(count(utility::post()) === 2 && utility::post('mobile') && !utility::post('password'))
				{
					$return = true;
				}
				break;

			default:
				$return = true;
				break;
		}
		return $return;
	}
}
?>