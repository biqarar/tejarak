<?php
namespace content_a\member\personal;


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
	public function post_personal($_args)
	{
		$this->user_id = \dash\user::id();
		$request       = $this->getPost();

		$member          = \dash\url::dir(3);
		$request['id']   = $member;
		$request['team'] = $team = \dash\url::dir(0);
		\dash\app::variable($request);

		// API ADD MEMBER FUNCTION
		$this->add_member(['method' => 'patch']);
	}
}
?>