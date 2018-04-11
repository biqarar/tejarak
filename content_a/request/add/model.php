<?php
namespace content_a\request\add;


class model
{


	/**
	 * Gets the post.
	 *
	 * @return     array  The post.
	 */
	public static function getPost()
	{
		$args               = [];
		$args['start_date'] = \dash\utility\human::number(\dash\request::post('start_date'), 'en');
		$args['start_time'] = \dash\utility\human::number(\dash\request::post('start_time'), 'en');
		$args['end_date']   = \dash\utility\human::number(\dash\request::post('end_date'), 'en');
		$args['end_time']   = \dash\utility\human::number(\dash\request::post('end_time'), 'en');
		$args['desc']       = \dash\request::post('desc');

		return $args;
	}


	/**
	 * save a request for edit time
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function post()
	{
		$request            = self::getPost();
		$request['team']    = \dash\request::get('id');
		$request['user_id'] = \dash\request::get('user');

		\dash\app::variable($request);
		\lib\app\houredit::add_houredit();
		if(\dash\engine\process::status())
		{
			\dash\redirect::to(\dash\url::here(). '/request?id='. $request['team']);
		}
	}
}
?>