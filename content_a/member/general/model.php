<?php
namespace content_a\member\general;
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
			'displayname'      => utility::post('name'),
			'postion'          => utility::post('postion'),
			'visibility'       => utility::post('visibility'),
		];

		if(utility::post('mobile')) $args['mobile'] = utility::post('mobile');
		if(utility::post('rule')) $args['rule']     = utility::post('rule');
		if(utility::post('status')) $args['status'] = utility::post('status');

		return $args;
	}





	/**
	 * Posts an addmember.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_general($_args)
	{
		$this->user_id = $this->login('id');
		$request       = $this->getPost();
		$member          = \lib\router::get_url(3);
		$request['id']   = $member;
		$request['team'] = $team = \lib\router::get_url(0);
		utility::set_request_array($request);

		// API ADD MEMBER FUNCTION
		$this->add_member(['method' => 'patch']);

		if(debug::$status)
		{
			$this->redirector(\lib\url::pwd());
		}
	}
}
?>