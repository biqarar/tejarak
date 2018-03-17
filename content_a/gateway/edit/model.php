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
			'name'     => \lib\request::post('name'),
			'username' => \lib\request::post('username'),
			'password' => \lib\request::post('ramz'),
			'status'   => (\lib\request::post('status') !== null)? 'active': 'deactive',
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
		$this->user_id   = $this->login('id');
		$request         = [];
		$request['team'] = $_team;
		$request['id']   = $_gateway;
		\lib\utility::set_request_array($request);
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
		if(!$this->login())
		{
			\lib\debug::error(T_("Please login to add a team"), false, 'arguments');
			return false;
		}

		$this->user_id = $this->login('id');
		$request       = $this->getPost();

		$url             = \lib\url::directory();
		$gateway         = \lib\url::dir(3);
		$request['id']   = $gateway;
		$request['team'] = $team = \lib\url::dir(0);
		\lib\utility::set_request_array($request);

		// API ADD gateway FUNCTION
		$this->add_gateway(['method' => 'patch']);
		if(\lib\debug::$status)
		{
			\lib\redirect::to()->set_domain()->set_url("a/$team/gateway");
		}
	}
}
?>