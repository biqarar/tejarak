<?php
namespace content_a\gateway\add;
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
		$args =
		[
			'name'     => utility::post('name'),
			'username' => utility::post('username'),
			'password' => utility::post('ramz'),
			'status'   => (utility::post('status') !== null)? 'active': 'deactive',
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
			debug::error(T_("Please login to add a team"), false, 'arguments');
			return false;
		}

		$this->user_id = $this->login('id');
		// ready request
		$request           = $this->getPost();

		$team = \lib\url::dir(0);
		// get posted data to create the request
		$request['team']  = $team;

		utility::set_request_array($request);

		// API ADD gateway FUNCTION
		$this->add_gateway();
		if(debug::$status)
		{
			$this->redirector()->set_domain()->set_url("a/$team/gateway");
		}

	}


}
?>