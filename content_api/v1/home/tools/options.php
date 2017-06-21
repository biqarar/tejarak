<?php
namespace content_api\v1\home\tools;

trait options
{

	/**
	 * make host string
	 *
	 * @param      string  $_type  The type
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function host($_type = null)
	{
		$host = Protocol."://" . \lib\router::get_root_domain();
		$lang = \lib\define::get_current_language_string();

		switch ($_type)
		{
			case 'file':
				return Protocol."://" . \lib\router::get_root_domain();
				break;

			case 'without_language':
				return $host;
				break;

			case 'with_language':
				return $host . $lang;
				break;

			default:
				return $host;
				break;
		}
	}
}
?>