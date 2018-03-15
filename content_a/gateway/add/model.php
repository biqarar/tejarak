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
		if(!$this->login())
		{
			\lib\debug::error(T_("Please login to add a team"), false, 'arguments');
			return false;
		}

		$this->user_id = $this->login('id');
		// ready request
		$request           = $this->getPost();

		$team = \lib\url::dir(0);
		// get posted data to create the request
		$request['team']  = $team;

		\lib\utility::set_request_array($request);

		// API ADD gateway FUNCTION
		$this->add_gateway();
		if(\lib\debug::$status)
		{
			$this->redirector()->set_domain()->set_url("a/$team/gateway");
		}

	}


}
?>