<?php
namespace content\hours;

class controller
{

	public static function routing()
	{
		$url = \dash\url::module();
		// this module name is hours
		// the house url can not be route
		if($url === 'hours')
		{
			\dash\header::status(404);
		}

		$list_member = \content\hours\view::list_member();

		if($list_member)
		{
			\dash\temp::set('list_member', $list_member);
		}
		elseif(\dash\temp::get('team_exist'))
		{
			\dash\header::status(403, T_("Access denied to load this team data"));
		}
	}
}
?>