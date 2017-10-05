<?php
namespace content_a\gateway;
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

		$team = \lib\router::get_url(0);
		// get posted data to create the request
		$request['team']  = $team;

		utility::set_request_array($request);

		// API ADD gateway FUNCTION
		$this->add_gateway();
		if(debug::$status)
		{
			$this->redirector()->set_domain()->set_url("a/$team/gateway/list");
		}

	}


	/**
	 * Gets the list.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function list_gateway($_args)
	{
		$this->user_id = $this->login('id');
		$request       = [];
		$request['id'] = isset($_args['id']) ? $_args['id'] : null;
		utility::set_request_array($request);
		$result =  $this->get_list_gateway();
		return $result;
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
		utility::set_request_array($request);
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
			debug::error(T_("Please login to add a team"), false, 'arguments');
			return false;
		}

		$this->user_id = $this->login('id');
		$request       = $this->getPost();

		$url             = \lib\router::get_url();
		$gateway          = substr($url, strpos($url,'=') + 1);
		$request['id']   = $gateway;
		$request['team'] = $team = \lib\router::get_url(0);
		utility::set_request_array($request);

		// API ADD gateway FUNCTION
		$this->add_gateway(['method' => 'patch']);
		if(debug::$status)
		{
			$this->redirector()->set_domain()->set_url("a/$team/gateway/list");
		}
	}
}
?>