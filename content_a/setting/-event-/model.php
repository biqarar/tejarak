<?php
namespace content_a\setting\event;
use \lib\debug;
use \lib\utility;

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
			'event_title'       => utility::post('event_title'),
			'event_date'        => utility\human::number(utility::post('event_date'), 'en'),
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
		$code = \lib\router::get_url(0);

		$request       = $this->getPost();
		$this->user_id = $this->login('id');
		$request['id'] = $code;

		utility::set_request_array($request);

		// THE API ADD TEAM FUNCTION BY METHOD PATHC
		$this->add_team(['method' => 'patch']);
	}
}
?>