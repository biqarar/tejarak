<?php
namespace content_a\teams\members;

class controller
{

	public static function routing()
	{
		\dash\permission::access('cp:user:members', 'block');
	}
}
?>