<?php
namespace content_a\gateway\add;


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
			'name'     => \lib\request::post('name'),
			'username' => \lib\request::post('username'),
			'password' => \lib\request::post('ramz'),
			'status'   => (\lib\request::post('status') !== null)? 'active': 'deactive',
		];

		return $args;
	}


	/**
	 * Posts an addgateway.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_add($_args)
	{
		// check the user is login
		if(!\lib\user::login())
		{
			\lib\notif::error(T_("Please login to add a team"), false, 'arguments');
			return false;
		}

		$this->user_id = \lib\user::id();
		// ready request
		$request           = $this->getPost();

		$team = \dash\url::dir(0);
		// get posted data to create the request
		$request['team']  = $team;

		\lib\utility::set_request_array($request);

		// API ADD gateway FUNCTION
		$this->add_gateway();
		if(\lib\engine\process::status())
		{
			\lib\redirect::to(\dash\url::here(). "/$team/gateway");
		}

	}


}
?>