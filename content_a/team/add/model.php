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
			'name'              => \lib\utility::post('name'),
			// 'website'           => \lib\utility::post('website'),
			'privacy'           => \lib\utility::post('privacy'),
			'short_name'        => \lib\utility::post('slug'),
			'desc'              => \lib\utility::post('desc'),
			// 'show_avatar'       => \lib\utility::post('showAvatar'),
			// 'quick_traffic'     => \lib\utility::post('quickTraffic'),
			// 'allow_plus'        => \lib\utility::post('allowPlus'),
			// 'allow_minus'       => \lib\utility::post('allowMinus'),
			// 'remote_user'       => \lib\utility::post('remoteUser'),
			// '24h'               => \lib\utility::post('24h'),
			// 'manual_time_enter' => \lib\utility::post('manual_time_enter'),
			// 'manual_time_exit'  => \lib\utility::post('manual_time_exit'),
			// 'language'          => \lib\utility::post('language'),
			// 'event_title'       => \lib\utility::post('event_title'),
			// 'event_date'        => \lib\utility\human::number(\lib\utility::post('event_date'), 'en'),
			// 'cardsize'          => \lib\utility::post('cardsize'),
			// 'allow_desc_enter'  => \lib\utility::post('allowDescEnter'),
			// 'allow_desc_exit'   => \lib\utility::post('allowDescExit'),
			// 'parent'      => \lib\utility::post('the-parent'),
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
		$this->user_id    = $this->login('id');
		\lib\utility::set_request_array($request);
		$this->add_team();

		if(\lib\debug::$status)
		{
			$new_team_code = \lib\temp::get('last_team_code_added');

			if($new_team_code)
			{
				// \lib\debug::msg('direct', true);
				$this->redirector()->set_domain()->set_url("a/$new_team_code/setting/plan");
			}
		}
	}
}
?>