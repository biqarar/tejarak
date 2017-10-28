<?php
namespace content_a\request\add;
use \lib\utility;
use \lib\debug;

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
		$args['start_date'] = \lib\utility\human::number(utility::post('start_date'), 'en');
		$args['start_time'] = \lib\utility\human::number(utility::post('start_time'), 'en');
		$args['end_date']   = \lib\utility\human::number(utility::post('end_date'), 'en');
		$args['end_time']   = \lib\utility\human::number(utility::post('end_time'), 'en');
		$args['desc']       = utility::post('desc');

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
		$request['team']    = \lib\router::get_url(0);
		$request['user_id'] = \lib\utility::get('user');

		utility::set_request_array($request);

		$this->user_id = $this->login('id');
		$this->add_houredit();
		if(debug::$status)
		{
			$this->redirector($this->url('baseFull'). '/'. $request['team']. '/request');
		}
	}
}
?>