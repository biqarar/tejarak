<?php
namespace content_a\member\general;


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
			'displayname'      => \dash\request::post('name'),
			'postion'          => \dash\request::post('postion'),
			'visibility'       => \dash\request::post('visibility'),
		];

		if(\dash\request::post('mobile')) $args['mobile'] = \dash\request::post('mobile');
		if(\dash\request::post('rule')) $args['rule']     = \dash\request::post('rule');
		if(\dash\request::post('status')) $args['status'] = \dash\request::post('status');

		return $args;
	}





	/**
	 * Posts an addmember.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_general($_args)
	{
		$this->user_id = \dash\user::id();
		$request       = $this->getPost();
		$member          = \dash\url::dir(3);
		$request['id']   = $member;
		$request['team'] = $team = \dash\url::dir(0);
		\dash\app::variable($request);

		// API ADD MEMBER FUNCTION
		$this->add_member(['method' => 'patch']);

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>