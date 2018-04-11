<?php
namespace content_a\sendnotify;

class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Send message as notify to team members"));
		\dash\data::page_desc(T_("You can send message to your team members and all of them if give this message as notification and if they are synced their telegram, they can give message in telegram"));
	}
}
?>