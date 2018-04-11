<?php
namespace content_a\gateway\edit;


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

		$request       = self::getPost();

		$url             = \dash\url::directory();
		$gateway         = \dash\request::get('gateway');
		$request['id']   = $gateway;
		$request['team'] = $team = \dash\request::get('id');
		\dash\app::variable($request);

		// API ADD gateway FUNCTION
		\lib\app\gateway::add_gateway(['method' => 'patch']);

		if(\dash\engine\process::status())
		{
			\dash\redirect::to(\dash\url::here(). "/gateway?id=". \dash\request::get('id'));
		}
	}
}
?>