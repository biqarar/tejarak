<?php
namespace content_cp\teamplans;

class controller
{

	public static function routing()
	{
		\dash\permission::access('cp:user', 'block');
	}
}
?>