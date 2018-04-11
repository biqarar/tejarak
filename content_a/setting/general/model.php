<?php
namespace content_a\setting\general;


class model
{
	/**
	 * Gets the post.
	 *
	 * @return     array  The post.
	 */
	public static function getPost()
	{
		$args = [];
		if(\dash\request::post('formType') === 'public')
		{
			$args =
			[
				'name'          => \dash\request::post('name'),
				'short_name'    => \dash\request::post('slug'),
				'website'       => \dash\request::post('website'),
				'desc'          => \dash\request::post('desc'),
				'privacy'       => \dash\request::post('privacy'),
			];

		}

		if(\dash\request::post('formType') === 'member')
		{
			$args =
			[
				'show_avatar'   => \dash\request::post('showAvatar'),
				// 'quick_traffic' => \dash\request::post('quickTraffic'),
				'allow_plus'    => \dash\request::post('allowPlus'),
				'allow_minus'   => \dash\request::post('allowMinus'),
				'remote_user'   => \dash\request::post('remoteUser'),
				'24h'           => \dash\request::post('24h'),
			];
		}

		return $args;
	}


	/**
	 * Posts an add.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function post()
	{
		$code = \dash\request::get('id');

		$request       = self::getPost();

		$request['id'] = $code;

		\dash\app::variable($request);

		// THE API ADD TEAM FUNCTION BY METHOD PATHC
		\lib\app\team::add_team(['method' => 'patch']);
		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>