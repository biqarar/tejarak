<?php
namespace content_a\setting\general;


class model extends \content_a\main\model
{
/**
	 * Gets the post.
	 *
	 * @return     array  The post.
	 */
	public function getPost()
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
	public function post_general($_args)
	{
		$code = \dash\url::dir(0);

		$request       = $this->getPost();
		$this->user_id = \dash\user::id();
		$request['id'] = $code;

		\dash\utility::set_request_array($request);

		// THE API ADD TEAM FUNCTION BY METHOD PATHC
		$this->add_team(['method' => 'patch']);
		if(\lib\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>