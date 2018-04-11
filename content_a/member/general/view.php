<?php
namespace content_a\member\general;

class view
{

	public static function config()
	{
		\content_a\member\view::master_config();
		$memberName = \dash\data::member_displayname();

		\dash\data::page_title(T_('General setting | :name', ['name' => $memberName]));
		\dash\data::page_desc(T_('Manage general setting of member like name and position, you can change another setting by choose another type of setting.'));

	}

}
?>