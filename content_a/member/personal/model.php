<?php
namespace content_a\member\personal;
use \lib\utility;
use \lib\debug;

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

			'firstname'        => utility::post('firstName'),
			'lastname'         => utility::post('lastName'),
			'personnel_code'   => utility::post('personnelcode'),
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

		$member          = \lib\router::get_url(3);
		$request['id']   = $member;
		$request['team'] = $team = \lib\router::get_url(0);
		utility::set_request_array($request);

		// API ADD MEMBER FUNCTION
		$this->add_member(['method' => 'patch']);
	}
}
?>