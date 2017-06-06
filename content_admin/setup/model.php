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
		// update user details
		$update_user = [];

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

		// check posted family
		if(!utility::post('family'))
		{
			debug::error(T_("Please enter your family"), 'family', 'arguments');
			return false;
		}

		if(utility::files('avatar'))
		{
			$this->user_id = $this->login('id');
			utility::set_request_array(['upload_name' => 'avatar']);
			$uploaded_file = $this->upload_file();
			if(isset($uploaded_file['code']))
			{
				$code = utility\shortURL::decode($uploaded_file['code']);
				$update_user['user_file_id'] = $code;
			}
			// if in upload have error return
			if(!debug::$status)
			{
				return false;
			}
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
			$update_user['user_displayname'] = utility::post('name');
		}

		// if the family exist update user display family
		if(utility::post('family') && utility::post('family') != $this->login('family'))
		{
			$update_user['user_family'] = utility::post('family');
		}

		// if the postion exist update user display postion
		if(utility::post('post') && utility::post('post') != $this->login('postion'))
		{
			$update_user['user_postion'] = utility::post('post');
		}

		// update user record
		if(!empty($update_user))
		{
			\lib\db\users::update($update_user, $this->login('id'));
			if(isset($_SESSION['user']) && is_array($_SESSION['user']))
			{
				array_merge($_SESSION['user'], $update_user);
			}
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