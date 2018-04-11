<?php
namespace content_a\member\permission;

class view
{

	public static function config()
	{
		\dash\data::page_title(T_('Special Access'));
		\dash\data::page_desc(T_('You can set some permission to member to do some more activity in Tejarak.'));
	}

}
?>