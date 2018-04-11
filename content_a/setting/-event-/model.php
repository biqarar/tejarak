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
			'event_title'       => \dash\request::post('event_title'),
			'event_date'        => \dash\utility\human::number(\dash\request::post('event_date'), 'en'),
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
		$code = \dash\request::get('id');

		$request       = $this->getPost();
		$this->user_id = \dash\user::id();
		$request['id'] = $code;

		\dash\app::variable($request);

		// THE API ADD TEAM FUNCTION BY METHOD PATHC
		$this->add_team(['method' => 'patch']);
	}
}
?>