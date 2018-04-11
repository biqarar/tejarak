<?php
namespace content_a\request;


class view
{
	public static function config()
	{
		$load_user_in_team = \dash\temp::get('userteam_login_detail');
		if(isset($load_user_in_team['24h']) && $load_user_in_team['24h'])
		{
			\dash\data::is24h(true);
		}

		\dash\data::page_title(T_('Request list'));
		\dash\data::page_desc(T_('See list of request registered and status of them. Depending on your permission you can do some actions.'));

		$args                     = [];
		$args['team']             = \dash\request::get('id');
		$args['user']             = \dash\request::get('user');
		$result                   = self::requestList($args);

		\dash\data::requestList($result);
		\dash\data::teamCode(\dash\request::get('id'));
	}


	public static function requestList($_request)
	{
		\dash\app::variable($_request);
		return \lib\app\houredit::get_houredit_list();
	}
}
?>