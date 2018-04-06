<?php
namespace content_a\setting\event;


class model extends \content_a\main\model
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
			'event_title'       => \lib\request::post('event_title'),
			'event_date'        => \lib\utility\human::number(\lib\request::post('event_date'), 'en'),
		];

		return $args;
	}


	/**
	 * Posts an add.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_event()
	{
		$code = \dash\url::dir(0);

		$request       = $this->getPost();
		$this->user_id = \lib\user::id();
		$request['id'] = $code;

		\lib\utility::set_request_array($request);

		// THE API ADD TEAM FUNCTION BY METHOD PATHC
		$this->add_team(['method' => 'patch']);
	}
}
?>