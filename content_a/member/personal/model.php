<?php
namespace content_a\member\personal;


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

			'firstname'        => \dash\request::post('firstName'),
			'lastname'         => \dash\request::post('lastName'),
			'personnel_code'   => \dash\request::post('personnelcode'),
		];

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
		\lib\app\member::add_member(['method' => 'patch']);
	}
}
?>