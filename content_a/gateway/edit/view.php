<?php
namespace content_a\gateway\edit;

class view
{
	/**
	 * edit gateway
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function config()
	{
		\dash\data::editMode(true);
		$url                   = \dash\url::directory();
		$team                  = \dash\request::get('id');
		$gateway               = \dash\request::get('gateway');
		$gateway               = self::edit($team, $gateway);
		\dash\data::gateway($gateway);

		if(isset($gateway['displayname']))
		{
			\dash\data::page_title(T_('Edit :name', ['name' => $gateway['displayname']]));
		}
		else
		{
			\dash\data::page_title(T_('Edit gateway!'));
		}
		\dash\data::page_desc(T_('change user and password of gateway or disable it.'));
	}


	public static function edit($_team, $_gateway)
	{
		$request         = [];
		$request['team'] = $_team;
		$request['id']   = $_gateway;
		\dash\app::variable($request);
		$result =  \lib\app\gateway::get_gateway();
		return $result;
	}
}
?>