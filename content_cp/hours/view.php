<?php
namespace content_cp\hours;

class view
{
	public static function config()
	{
		$result = \lib\db\hours::getLastHursTeam();
		\dash\data::hoursList($result);
	}
}
?>