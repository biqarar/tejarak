<?php
namespace content_a\team\add;


class model extends \content_a\main\model
{



	/**
	 * Gets the post.
	 *
	 * @return     array  The post.
	 */
	public function getPost()
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
	public function post_add($_args)
	{
		$request          = $this->getPost();
		if($request === false)
		{
			return false;
		}
		$this->user_id    = \dash\user::id();
		\dash\utility::set_request_array($request);
		$this->add_team();

		if(\dash\engine\process::status())
		{
			$new_team_code = \dash\temp::get('last_team_code_added');

			if($new_team_code)
			{
				// \dash\notif::direct();
				\dash\redirect::to(\dash\url::here(). "/$new_team_code/setting/plan");
			}
		}
	}
}
?>