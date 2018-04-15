<?php
namespace content_a\request\hour;

class view
{
	/**
	 * view to hour team
	 */
	public static function config()
	{
		\dash\data::page_title(T_('Request edit existing hour'));
		\dash\data::page_desc(T_('you can register a change request for this time record.'));

		$load_user_in_team = \dash\temp::get('userteam_login_detail');

		if(isset($load_user_in_team['24h']) && $load_user_in_team['24h'])
		{
			\dash\data::is24h(true);
		}

		if(\dash\request::get('hourid'))
		{
			$args                     = [];
			$args['team']             = \dash\request::get('id');
			$args['user']             = \dash\request::get('user');
			$result                   = self::requestList($args);

			\dash\data::requestList($result);
			\dash\data::teamCode(\dash\request::get('id'));
		}
	}


	public static function requestList($_request)
	{
		\dash\app::variable($_request);
		return \lib\app\houredit::get_houredit_list();
	}


}
?>