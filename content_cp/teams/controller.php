<?php
namespace content_cp\teams;

class controller
{

	public static function routing()
	{
		\dash\permission::access('cp:user', 'block');
	}
}
?>