<?php
namespace content_a\setting\general;
use \lib\debug;
use \lib\utility;

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
		if(utility::post('formType') === 'public')
		{
			$args =
			[
				'name'          => utility::post('name'),
				'short_name'    => utility::post('slug'),
				'website'       => utility::post('website'),
				'desc'          => utility::post('desc'),
				'privacy'       => utility::post('privacy'),
			];

		}

		if(utility::post('formType') === 'member')
		{
			$args =
			[
				'show_avatar'   => utility::post('showAvatar'),
				// 'quick_traffic' => utility::post('quickTraffic'),
				'allow_plus'    => utility::post('allowPlus'),
				'allow_minus'   => utility::post('allowMinus'),
				'remote_user'   => utility::post('remoteUser'),
				'24h'           => utility::post('24h'),
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
		$code = \lib\url::dir(0);

		$request       = $this->getPost();
		$this->user_id = $this->login('id');
		$request['id'] = $code;

		utility::set_request_array($request);

		// THE API ADD TEAM FUNCTION BY METHOD PATHC
		$this->add_team(['method' => 'patch']);
		if(debug::$status)
		{
			$this->redirector(\lib\url::pwd());
		}
	}
}
?>