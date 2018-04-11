<?php
namespace content_a\team\add;

class view
{
	/**
	 * view to add team
	 */
	public static function config()
	{
		\dash\data::page_title(T_('Add new team'));
		\dash\data::page_desc(T_('Set some basic detail, after insert you can add avatar and change all settings'));
	}
}
?>