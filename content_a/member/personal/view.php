<?php
namespace content_a\member\personal;

class view
{

	public static function config()
	{
		\dash\data::page_title(T_('personal member!'));
		\dash\data::page_desc(\dash\data::page_title());
	}
}
?>