<?php
namespace content_a\member\general;


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
	public static function post()
	{

		$request       = self::getPost();
		$member          = \dash\request::get('member');
		$request['id']   = $member;
		$request['team'] = $team = \dash\request::get('id');
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