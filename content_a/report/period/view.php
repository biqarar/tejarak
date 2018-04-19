<?php
namespace content_a\report\period;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_('Report in period of time'));
		\dash\data::page_desc(T_('check last attendace data and filter it based on member and see it for specefic member and exprort data of them.'));

		if(\dash\request::get('start'))
		{
			\dash\data::getStart_date(\dash\request::get('start'));
		}

		if(\dash\request::get('end'))
		{
			\dash\data::getEnd_date(\dash\request::get('end'));
		}

		\content_a\report\view::showAllUser();

		$args           = [];
		$args['id']     = \dash\request::get('id');
		$args['start']  = \dash\request::get('start');
		$args['end']    = \dash\request::get('end');
		$args['user']   = \dash\request::get('user');
		$args['export'] = \dash\request::get('export');
		\dash\data::periodTime(self::get_period_time($args));
	}


	public static function get_period_time($_request)
	{
		\dash\app::variable($_request);
		return \lib\app\report::report_period_time();
	}

}
?>