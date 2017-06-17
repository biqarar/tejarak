<?php
namespace content_a\setup;
use \lib\debug;
use \lib\utility;

class model extends \content_a\main\model
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
			$this->redirector()->set_domain()->set_url('a/setup/2');
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
		$user_session = [];

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
		// check name lenght
		if(mb_strlen(utility::post('name')) > 90)
		{
			debug::error(T_("Please enter your name less than 90 character"), 'name', 'arguments');
			return false;
		}

		$file_code = null;
		if(utility::files('avatar'))
		{
			$this->user_id = $this->login('id');
			utility::set_request_array(['upload_name' => 'avatar']);
			$uploaded_file = $this->upload_file();
			if(isset($uploaded_file['code']))
			{
				$file_code = $uploaded_file['code'];
				$file_id = utility\shortURL::decode($uploaded_file['code']);
				$update_user['user_file_id'] = $file_id;
				$user_session['file_id'] = $update_user['user_file_id'];
			}
			// if in upload have error return
			if(!debug::$status)
			{
				return false;
			}
		}

		// if the name exist update user display name
		if(utility::post('name') && utility::post('name') != $this->login('name'))
		{
			$update_user['user_name'] = utility::post('name');
			$user_session['name'] = $update_user['user_name'];
		}

		// if the family exist update user display family
		if(utility::post('family') && utility::post('family') != $this->login('family'))
		{
			$update_user['user_family'] = utility::post('family');
			$user_session['family'] = $update_user['user_family'];
		}

		// if the postion exist update user display postion
		if(utility::post('post') && utility::post('post') != $this->login('postion'))
		{
			$update_user['user_postion'] = utility::post('post');
			$user_session['postion'] = $update_user['user_postion'];
		}

		// update user record
		if(!empty($update_user))
		{
			\lib\db\users::update($update_user, $this->login('id'));
			if(isset($_SESSION['user']) && is_array($_SESSION['user']))
			{
				$_SESSION['user'] = array_merge($_SESSION['user'], $user_session);
			}
		}
		// add user to team member and centeral branch member
		$request            = [];
		$request['mobile']  = $this->login('mobile');
		$request['name']    = utility::post('name');
		$request['family']  = utility::post('family');
		$request['postion'] = utility::post('post');
		$request['file']    = $file_code;
		$request['team']    = isset($_SESSION['last_team_added']) ? $_SESSION['last_team_added'] : null;
		$request['branch']  = 'centeral';
		utility::set_request_array($request);
		$this->user_id      = $this->login('id');
		// API ADD MEMBER FUNCTION
		$this->add_member();

		// if the member is added redirect to setup 3
		if(debug::$status)
		{
			$this->redirector()->set_domain()->set_url('a/setup/3');
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