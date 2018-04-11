<?php
namespace content_a\report\last;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_('Last traffic reports'));
		\dash\data::page_desc(T_('check last attendace data and filter it based on member and see it for specefic member and exprort data of them.'));

		$args                  = [];
		$args['id']            = \dash\request::get('id');


		if(\dash\request::get('user'))
		{
			$args['user'] = \dash\request::get('user');
		}

		$args['export'] = \dash\request::get('export');

		\dash\data::lastTime(self::get_last_time($args));
	}


	public static function get_last_time($_request)
	{
		\dash\app::variable($_request);
		return \lib\app\report::report_last_time();
	}

}
?>