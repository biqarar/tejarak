<?php
namespace content_a\request\add;


class model extends \content_a\main\model
{


	/**
	 * Gets the post.
	 *
	 * @return     array  The post.
	 */
	public function getPost()
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
	public function post_add($_args)
	{
		$request            = $this->getPost();
		$request['team']    = \dash\url::dir(0);
		$request['user_id'] = \dash\request::get('user');

		\dash\utility::set_request_array($request);

		$this->user_id = \dash\user::id();
		$this->add_houredit();
		if(\lib\engine\process::status())
		{
			\dash\redirect::to(\dash\url::here(). '/'. $request['team']. '/request');
		}
	}
}
?>