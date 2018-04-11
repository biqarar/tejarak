<?php
namespace content_a\member\permission;


class model
{

	public static function getPost()
	{
		$args =
		[

			'allow_plus'       => \dash\request::post('allowPlus'),
			'allow_minus'      => \dash\request::post('allowMinus'),
			'remote_user'      => \dash\request::post('remoteUser'),
			'24h'              => \dash\request::post('24h'),
			// 'allow_desc_enter' => \dash\request::post('allowDescEnter'),
			// 'allow_desc_exit'  => \dash\request::post('allowDescExit'),
		];
		return $args;
	}


	public static function post()
	{
		$request         = self::getPost();
		$member          = \dash\request::get('member');
		$request['id']   = $member;
		$request['team'] = \dash\request::get('id');
		\dash\app::variable($request);

		// API ADD MEMBER FUNCTION
		\lib\app\member::add_member(['method' => 'patch']);
	}
}
?>