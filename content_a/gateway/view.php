<?php
namespace content_a\gateway;

class view
{

	/**
	 * get list of gateway on this team and branch
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function config()
	{
		$request['id']            = \dash\request::get('id');
		\dash\app::variable($request);
		$list =  \lib\app\gateway::get_list_gateway();

		\dash\data::listGateway($list);

		\dash\data::page_title(T_('gateway'));
		\dash\data::page_desc(T_('Gateway is a simple user that allow to see Tejarak board and set enter and exit of members.'). ' '. T_('This is useful when you dont want to login with your admin account and only want to register attendance data.'));
	}

}
?>