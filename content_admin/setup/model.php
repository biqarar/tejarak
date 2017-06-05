<?php
namespace content_admin\setup;
use \lib\debug;
use \lib\utility;

class model extends \content_admin\main\model
{
	/**
	 * Gets the setup 1.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function setup1()
	{

	}


	/**
	 * Gets the setup 2.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function setup2()
	{

	}


	/**
	 * Gets the setup 3.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function setup3()
	{

	}


	/**
	 * add team
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_setup1()
	{
		// check the user is login
		if(!$this->login())
		{
			debug::error(T_("Please login to add a team"), false, 'arguments');
			return false;
		}
		// check posted title
		if(!utility::post('title'))
		{
			debug::error(T_("Please enter the team title"), 'title', 'arguments');
			return false;
		}
		// set user id to use in api
		$this->user_id = $this->login('id');
		// set the posted title in request to use in api
		utility::set_request_array(['title' => utility::post('title')]);
		// API ADD TEAM FUNCTION
		$this->add_team();
		// save last team added to session to get in step 3
		$_SESSION['last_team_added'] = \lib\storage::get_last_team_added();

		// if the team is added redirect to setup 2
		if(debug::$status)
		{
			$this->redirector()->set_domain()->set_url('admin/setup/2');
		}
	}


	/**
	 * Posts a setup 2.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_setup2($_args)
	{
		// check the user is login
		if(!$this->login())
		{
			debug::error(T_("Please login to add a team"), false, 'arguments');
			return false;
		}

		// check posted name
		if(!utility::post('name'))
		{
			debug::error(T_("Please enter your name"), 'name', 'arguments');
			return false;
		}
		// check name lenght
		if(mb_strlen(utility::post('name')) > 90)
		{
			debug::error(T_("Please enter your name less than 90 character"), 'name', 'arguments');
			return false;
		}
		// if the name exist update user display name
		if(utility::post('name') && utility::post('name') != $this->login('displayname'))
		{
			\lib\db\users::update(['user_displayname' => utility::post('name')], $this->login('id'));
			$_SESSION['user']['displayname'] = utility::post('name');
		}

		// if the team is added redirect to setup 3
		if(debug::$status)
		{
			$this->redirector()->set_domain()->set_url('admin/setup/3');
		}

	}


	/**
	 * Posts a setup 3.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_setup3($_args)
	{

	}
}
?>