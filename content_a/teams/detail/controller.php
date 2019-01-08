<?php
namespace content_a\teams\detail;

class controller
{
	public static function routing()
	{
		\dash\permission::access('cp:user:detail', 'block');
	}
}
?>