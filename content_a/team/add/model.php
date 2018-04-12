<?php
namespace content_a\team\add;


class model
{



	/**
	 * Gets the post.
	 *
	 * @return     array  The post.
	 */
	public static function getPost()
	{
		$args =
		[
			'name'              => \dash\request::post('name'),
			// 'website'           => \dash\request::post('website'),
			'privacy'           => \dash\request::post('privacy'),
			'short_name'        => \dash\request::post('slug'),
			'desc'              => \dash\request::post('desc'),
			// 'show_avatar'       => \dash\request::post('showAvatar'),
			// 'quick_traffic'     => \dash\request::post('quickTraffic'),
			// 'allow_plus'        => \dash\request::post('allowPlus'),
			// 'allow_minus'       => \dash\request::post('allowMinus'),
			// 'remote_user'       => \dash\request::post('remoteUser'),
			// '24h'               => \dash\request::post('24h'),
			// 'manual_time_enter' => \dash\request::post('manual_time_enter'),
			// 'manual_time_exit'  => \dash\request::post('manual_time_exit'),
			// 'language'          => \dash\request::post('language'),
			// 'event_title'       => \dash\request::post('event_title'),
			// 'event_date'        => \dash\utility\human::number(\dash\request::post('event_date'), 'en'),
			// 'cardsize'          => \dash\request::post('cardsize'),
			// 'allow_desc_enter'  => \dash\request::post('allowDescEnter'),
			// 'allow_desc_exit'   => \dash\request::post('allowDescExit'),
			// 'parent'      => \dash\request::post('the-parent'),
		];

		return $args;
	}



	/**
	 * Posts an add.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function post()
	{
		$request          = self::getPost();
		if($request === false)
		{
			return false;
		}

		\dash\app::variable($request);
		\lib\app\team::add_team();

		if(\dash\engine\process::status())
		{
			$new_teamCode = \dash\temp::get('last_team_code_added');

			if($new_teamCode)
			{
				// \dash\notif::direct();
				\dash\redirect::to(\dash\url::here(). "/setting/plan?id=$new_teamCode");
			}
		}
	}
}
?>