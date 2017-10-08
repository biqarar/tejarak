<?php
namespace content_a\setting\board;
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
		$args = [];
		if(utility::post('formType') === 'event')
		{
			$args =
			[
				'event_title'      => utility::post('event_title'),
				'event_date_start' => utility\human::number(utility::post('event_date_start'), 'en'),
				'event_date'       => utility\human::number(utility::post('event_date'), 'en'),
			];
		}

		if(utility::post('formType') === 'board')
		{
			$args =
			[
				'language'    => utility::post('language'),
				'cardsize'    => utility::post('cardsize'),
			];
		}

		return $args;
	}


	/**
	 * Posts an add.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_board()
	{
		$code          = \lib\router::get_url(0);
		$request       = $this->getPost();

		$this->user_id = $this->login('id');
		$request['id'] = $code;
		utility::set_request_array($request);
		// THE API ADD TEAM FUNCTION BY METHOD PATHC
		$this->add_team(['method' => 'patch']);
	}
}
?>