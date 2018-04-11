<?php
namespace content_a\request\add;

class view
{
	public static function config()
	{
		\dash\data::page_title(T_('Add new request'));
		\dash\data::page_desc(T_('You can add new request of time and after confirm of team admin, this time is added to your hours.'));
	}
}
?>