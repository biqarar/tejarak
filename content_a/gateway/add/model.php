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
			'name'     => \dash\request::post('name'),
			'username' => \dash\request::post('username'),
			'password' => \dash\request::post('ramz'),
			'status'   => (\dash\request::post('status') !== null)? 'active': 'deactive',
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
		if(!\dash\user::login())
		{
			\dash\notif::error(T_("Please login to add a team"), false, 'arguments');
			return false;
		}

		$this->user_id = \dash\user::id();
		// ready request
		$request           = $this->getPost();

		$team = \dash\url::dir(0);
		// get posted data to create the request
		$request['team']  = $team;

		\dash\utility::set_request_array($request);

		// API ADD gateway FUNCTION
		$this->add_gateway();
		if(\lib\engine\process::status())
		{
			\dash\redirect::to(\dash\url::here(). "/$team/gateway");
		}

	}


}
?>