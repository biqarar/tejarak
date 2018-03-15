<?php
namespace content_a\setting\board;


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
		if(\lib\utility::post('formType') === 'event')
		{
			$args =
			[
				'event_title'      => \lib\utility::post('event_title'),
				'event_date_start' => \lib\utility\human::number(\lib\utility::post('event_date_start'), 'en'),
				'event_date'       => \lib\utility\human::number(\lib\utility::post('event_date'), 'en'),
			];
		}

		if(\lib\utility::post('formType') === 'board')
		{
			$args =
			[
				'language'    => \lib\utility::post('language'),
				'cardsize'    => \lib\utility::post('cardsize'),
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
		$code          = \lib\url::dir(0);
		$request       = $this->getPost();

		$this->user_id = $this->login('id');
		$request['id'] = $code;
		\lib\utility::set_request_array($request);
		// THE API ADD TEAM FUNCTION BY METHOD PATHC
		$this->add_team(['method' => 'patch']);
	}
}
?>