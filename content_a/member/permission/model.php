<?php
namespace content_a\member\permission;


class model extends \content_a\member\model
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

			'allow_plus'       => \lib\request::post('allowPlus'),
			'allow_minus'      => \lib\request::post('allowMinus'),
			'remote_user'      => \lib\request::post('remoteUser'),
			'24h'              => \lib\request::post('24h'),
			// 'allow_desc_enter' => \lib\request::post('allowDescEnter'),
			// 'allow_desc_exit'  => \lib\request::post('allowDescExit'),
		];

		return $args;
	}





	/**
	 * Posts an addmember.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_permission($_args)
	{
		$this->user_id   = \lib\user::id();
		$request         = $this->getPost();
		$member          = \dash\url::dir(3);
		$request['id']   = $member;
		$request['team'] = $team = \dash\url::dir(0);
		\lib\utility::set_request_array($request);

		// API ADD MEMBER FUNCTION
		$this->add_member(['method' => 'patch']);
	}
}
?>