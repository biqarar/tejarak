<?php
namespace content_a\member\add;

class view
{
	public static function config()
	{
		\dash\data::page_title(T_('Add new member'));
		\dash\data::page_desc(T_('You can set detail of team member and assign some extra data to use later'));
	}
}
?>