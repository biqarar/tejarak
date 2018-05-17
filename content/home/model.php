<?php
namespace content\home;


class model
{

	public static function post()
	{

		if(!\dash\user::login())
		{
			return false;
		}

		$url = \dash\url::module();

		if(!$url)
		{
			return false;
		}

		$url = explode("/", $url);

		$request           = [];

		/**
		 * ajax to check members status
		 */
		if(\dash\request::post('check'))
		{
			$request['shortname'] = isset($url[0]) ? $url[0] : null;
			$request['hours']     = true;

			// to get last hours. what i want to do?
			\dash\app::variable($request);
			$result = \lib\app\member::get_list_member();
			\dash\notif::result(['memberList' => json_encode($result, JSON_UNESCAPED_UNICODE)]);
			return true;
		}

		$request['team']   = \dash\url::module();
		$request['user']   = \dash\request::post('user');
		$request['plus']   = \dash\request::post('plus');
		$request['minus']  = \dash\request::post('minus');
		$request['type']   = \dash\request::post('type');
		$request['desc']   = \dash\request::post('desc');

		\dash\app::variable($request);
		\lib\app\hours::add_hours();

		\dash\notif::result(
			[
				'now_val' => date("Y-m-d H:i:s"),
				'now'     => date("H:i"),
				'user'    => \dash\request::post('user'),
			]);

	}
}
?>