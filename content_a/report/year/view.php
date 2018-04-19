<?php
namespace content_a\report\year;


class view
{
	public static function config()
	{

		\dash\data::page_title(T_('Report group by year'));
		\dash\data::page_desc(T_('check last attendace data and filter it based on member and see it for specefic member and exprort data of them.'));

		$args           = [];
		$args['id']     = \dash\request::get('id');
		$args['export'] = \dash\request::get('export');


		\content_a\report\view::showAllUser();


		if(\dash\request::get('user'))
		{
			$args['user'] = \dash\request::get('user');
		}

		if(\dash\request::get('year'))
		{
			$args['year'] = \dash\request::get('year');
		}

		\dash\data::yearTime(self::getYear_time($args));
	}


	public static function getYear_time($_request)
	{
		\dash\app::variable($_request);
		return \lib\app\report::report_year_time();
	}
}
?>