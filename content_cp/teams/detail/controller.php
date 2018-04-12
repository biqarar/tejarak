<?php
namespace content_cp\teams\detail;

class controller
{
	public static function routing()
	{
		\dash\permission::access('cp:user:detail', 'block');
	}
}
?>