<?php
namespace content_a\teams\hours;


class controller
{
	public static function routing()
	{
		\dash\permission::access('cp:user:hours', 'block');
	}
}
?>