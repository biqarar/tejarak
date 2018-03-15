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

			'firstname'        => \lib\utility::post('firstName'),
			'lastname'         => \lib\utility::post('lastName'),
			'personnel_code'   => \lib\utility::post('personnelcode'),
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
		$this->user_id = $this->login('id');
		$request       = $this->getPost();

		$member          = \lib\url::dir(3);
		$request['id']   = $member;
		$request['team'] = $team = \lib\url::dir(0);
		\lib\utility::set_request_array($request);

		// API ADD MEMBER FUNCTION
		$this->add_member(['method' => 'patch']);
	}
}
?>