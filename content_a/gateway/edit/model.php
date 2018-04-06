<?php
namespace content_a\gateway\edit;


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
	 * ready to edit gateway
	 * load data
	 *
	 * @param      <type>  $_team    The team
	 * @param      <type>  $_gateway  The gateway
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function edit($_team, $_gateway)
	{
		$this->user_id   = \dash\user::id();
		$request         = [];
		$request['team'] = $_team;
		$request['id']   = $_gateway;
		\dash\utility::set_request_array($request);
		$result =  $this->get_gateway();
		return $result;
	}


	/**
	 * Posts an addgateway.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_edit($_args)
	{
		// check the user is login
		if(!\dash\user::login())
		{
			\dash\notif::error(T_("Please login to add a team"), false, 'arguments');
			return false;
		}

		$this->user_id = \dash\user::id();
		$request       = $this->getPost();

		$url             = \dash\url::directory();
		$gateway         = \dash\url::dir(3);
		$request['id']   = $gateway;
		$request['team'] = $team = \dash\url::dir(0);
		\dash\utility::set_request_array($request);

		// API ADD gateway FUNCTION
		$this->add_gateway(['method' => 'patch']);
		if(\lib\engine\process::status())
		{
			\dash\redirect::to(\dash\url::here(). "/$team/gateway");
		}
	}
}
?>