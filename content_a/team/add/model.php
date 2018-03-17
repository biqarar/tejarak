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
			'name'              => \lib\request::post('name'),
			// 'website'           => \lib\request::post('website'),
			'privacy'           => \lib\request::post('privacy'),
			'short_name'        => \lib\request::post('slug'),
			'desc'              => \lib\request::post('desc'),
			// 'show_avatar'       => \lib\request::post('showAvatar'),
			// 'quick_traffic'     => \lib\request::post('quickTraffic'),
			// 'allow_plus'        => \lib\request::post('allowPlus'),
			// 'allow_minus'       => \lib\request::post('allowMinus'),
			// 'remote_user'       => \lib\request::post('remoteUser'),
			// '24h'               => \lib\request::post('24h'),
			// 'manual_time_enter' => \lib\request::post('manual_time_enter'),
			// 'manual_time_exit'  => \lib\request::post('manual_time_exit'),
			// 'language'          => \lib\request::post('language'),
			// 'event_title'       => \lib\request::post('event_title'),
			// 'event_date'        => \lib\utility\human::number(\lib\request::post('event_date'), 'en'),
			// 'cardsize'          => \lib\request::post('cardsize'),
			// 'allow_desc_enter'  => \lib\request::post('allowDescEnter'),
			// 'allow_desc_exit'   => \lib\request::post('allowDescExit'),
			// 'parent'      => \lib\request::post('the-parent'),
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
		$this->user_id    = \lib\user::id();
		\lib\utility::set_request_array($request);
		$this->add_team();

		if(\lib\notif::$status)
		{
			$new_team_code = \lib\temp::get('last_team_code_added');

			if($new_team_code)
			{
				// \lib\notif::msg('direct', true);
				\lib\redirect::to()->set_domain()->set_url("a/$new_team_code/setting/plan");
			}
		}
	}
}
?>