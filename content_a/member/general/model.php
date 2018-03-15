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
			'displayname'      => \lib\request::post('name'),
			'postion'          => \lib\request::post('postion'),
			'visibility'       => \lib\request::post('visibility'),
		];

		if(\lib\request::post('mobile')) $args['mobile'] = \lib\request::post('mobile');
		if(\lib\request::post('rule')) $args['rule']     = \lib\request::post('rule');
		if(\lib\request::post('status')) $args['status'] = \lib\request::post('status');

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
		$member          = \lib\url::dir(3);
		$request['id']   = $member;
		$request['team'] = $team = \lib\url::dir(0);
		\lib\utility::set_request_array($request);

		// API ADD MEMBER FUNCTION
		$this->add_member(['method' => 'patch']);

		if(\lib\debug::$status)
		{
			$this->redirector(\lib\url::pwd());
		}
	}
}
?>