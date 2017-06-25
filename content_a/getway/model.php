<?php
namespace content_a\getway;
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
			'name'   => utility::post('name'),
			'ip'     => utility::post('ip'),
			'agent'  => utility::post('agent'),
			'status' => utility::post('status'),
		];

		return $args;
	}


	/**
	 * Posts an addgetway.
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

		// API ADD getway FUNCTION
		$this->add_getway();
		if(debug::$status)
		{
			$this->redirector()->set_domain()->set_url("a/$team/getway/list");
		}

	}


	/**
	 * Gets the list.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function list_getway($_args)
	{
		$this->user_id = $this->login('id');
		$request       = [];
		$request['id'] = isset($_args['id']) ? $_args['id'] : null;
		utility::set_request_array($request);
		$result =  $this->get_list_getway();
		return $result;
	}


	/**
	 * ready to edit getway
	 * load data
	 *
	 * @param      <type>  $_team    The team
	 * @param      <type>  $_getway  The getway
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function edit($_team, $_getway)
	{
		$this->user_id   = $this->login('id');
		$request         = [];
		$request['team'] = $_team;
		$request['id']   = $_getway;
		utility::set_request_array($request);
		$result =  $this->get_getway();
		return $result;
	}


	/**
	 * Posts an addgetway.
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
		$getway          = substr($url, strpos($url,'=') + 1);
		$request['id']   = $getway;
		$request['team'] = $team = \lib\router::get_url(0);
		utility::set_request_array($request);

		// API ADD getway FUNCTION
		$this->add_getway(['method' => 'patch']);
		if(debug::$status)
		{
			$this->redirector()->set_domain()->set_url("a/$team/getway/list");
		}
	}
}
?>