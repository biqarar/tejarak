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
			'displayname'      => \lib\utility::post('name'),
			'postion'          => \lib\utility::post('postion'),
			'visibility'       => \lib\utility::post('visibility'),
		];

		if(\lib\utility::post('mobile')) $args['mobile'] = \lib\utility::post('mobile');
		if(\lib\utility::post('rule')) $args['rule']     = \lib\utility::post('rule');
		if(\lib\utility::post('status')) $args['status'] = \lib\utility::post('status');

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