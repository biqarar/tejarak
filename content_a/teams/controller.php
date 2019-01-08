<?php
namespace content_a\teams;

class controller
{

	public static function routing()
	{
		\dash\permission::access('cp:user', 'block');
	}
}
?>