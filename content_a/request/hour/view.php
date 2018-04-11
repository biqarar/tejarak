<?php
namespace content_a\request\hour;

class view
{
	/**
	 * view to hour team
	 */
	public static function config()
	{
		\dash\data::page_title(T_('Request edit existing hour'));
		\dash\data::page_desc(T_('you can register a change request for this time record.'));
	}
}
?>