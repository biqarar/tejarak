<?php
namespace content_a\setting\board;


class model
{

	/**
	 * Gets the post.
	 *
	 * @return     array  The post.
	 */
	public static function getPost()
	{
		$args = [];
		if(\dash\request::post('formType') === 'event')
		{
			$args =
			[
				'event_title'      => \dash\request::post('event_title'),
				'event_date_start' => \dash\utility\human::number(\dash\request::post('event_date_start'), 'en'),
				'event_date'       => \dash\utility\human::number(\dash\request::post('event_date'), 'en'),
			];
		}

		if(\dash\request::post('formType') === 'board')
		{
			$args =
			[
				'language'    => \dash\request::post('language'),
				'cardsize'    => \dash\request::post('cardsize'),
			];
		}

		return $args;
	}


	/**
	 * Posts an add.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function post()
	{
		$code          = \dash\request::get('id');
		$request       = self::getPost();

		$request['id'] = $code;
		\dash\app::variable($request);
		// THE API ADD TEAM FUNCTION BY METHOD PATHC
		\lib\app\team::add_team(['method' => 'patch']);
	}
}
?>