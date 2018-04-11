<?php
namespace content_a\profile\parent;

class view
{
	public static function config()
	{
		$list = \content_a\profile\parent\model::list_parent();

		\dash\data::parentList($list);
	}
}
?>