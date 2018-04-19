<?php
namespace content_cp\hours;


class controller
{
	public static function routing()
	{
		\dash\permission::access('cp:user:hours', 'block');
	}
}
?>