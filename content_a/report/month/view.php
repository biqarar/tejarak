<?php
namespace content_a\report\month;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_('Report group by month'));
		\dash\data::page_desc(T_('check last attendace data and filter it based on member and see it for specefic member and exprort data of them.'));

		if(\dash\request::get('year') && is_numeric(\dash\request::get('year')) && mb_strlen(\dash\request::get('year')) === 4)
		{
			\dash\data::getYear(\dash\request::get('year'));
		}

		if(\dash\request::get('month') && is_numeric(\dash\request::get('month')) && mb_strlen(\dash\request::get('month')) <= 2)
		{
			\dash\data::getMonth(\dash\request::get('month'));
		}

		\content_a\report\view::showAllUser();


		$args           = [];
		$args['id']     = \dash\request::get('id');
		$args['year']   = \dash\request::get('year');
		$args['month']  = \dash\request::get('month');
		$args['user']   = \dash\request::get('user');
		$args['export'] = \dash\request::get('export') ? true : false;

		\dash\data::monthTime(self::get_month_time($args));
	}

	public static function get_month_time($_request)
	{

		\dash\app::variable($_request);
		return \lib\app\report::report_month_time();
	}
}
?>