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

			'allow_plus'       => \dash\request::post('allowPlus'),
			'allow_minus'      => \dash\request::post('allowMinus'),
			'remote_user'      => \dash\request::post('remoteUser'),
			'24h'              => \dash\request::post('24h'),
			// 'allow_desc_enter' => \dash\request::post('allowDescEnter'),
			// 'allow_desc_exit'  => \dash\request::post('allowDescExit'),
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
		$this->user_id   = \dash\user::id();
		$request         = $this->getPost();
		$member          = \dash\request::get('member');
		$request['id']   = $member;
		$request['team'] = $team = \dash\request::get('id');
		\dash\app::variable($request);

		// API ADD MEMBER FUNCTION
		$this->add_member(['method' => 'patch']);
	}
}
?>