<?php
namespace content_a\setting\delete;


class model
{
	public static function post()
	{
		$code = \dash\request::get('id');

		\dash\app::variable(['id' => $code]);
		\lib\app\team::close_team();

		if(\dash\engine\process::status())
		{
			// \dash\notif::direct();
			\dash\redirect::pwd();
		}
	}
}
?>