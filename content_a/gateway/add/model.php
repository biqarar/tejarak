<?php
namespace content_a\gateway\add;


class model
{

	/**
	 * Gets the post.
	 *
	 * @return     array  The post.
	 */
	public static function getPost()
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
	public static function post()
	{
		// check the user is login
		if(!\dash\user::login())
		{
			\dash\notif::error(T_("Please login to add a team"), false, 'arguments');
			return false;
		}

		// ready request
		$request           = self::getPost();

		$team = \dash\request::get('id');
		// get posted data to create the request
		$request['team']  = $team;

		\dash\app::variable($request);

		// API ADD gateway FUNCTION
		\lib\app\gateway::add_gateway();

		if(\dash\engine\process::status())
		{
			\dash\redirect::to(\dash\url::here(). "/gateway?id=". \dash\request::get('id'));
		}

	}


}
?>