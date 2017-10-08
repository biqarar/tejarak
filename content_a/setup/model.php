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
		utility::set_request_array(['name' => utility::post('title')]);
		// API ADD TEAM FUNCTION
		$this->add_team();
		// save last team added to session to get in step 3
		$_SESSION['last_team_added']      = \lib\temp::get('last_team_added');
		$_SESSION['last_team_added_code'] = \lib\temp::get('last_team_code_added');

		// change param team to load again true
		if(isset($_SESSION['param']['team']))
		{
			$_SESSION['param']['team'] = utility::post('title');
		}
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

		// check name lenght
		if(mb_strlen(utility::post('name')) > 50)
		{
			debug::error(T_("Please enter your name less than 50 character"), 'name', 'arguments');
			return false;
		}

		$file_code = null;
		if(utility::files('avatar'))
		{
			$this->user_id = $this->login('id');
			utility::set_request_array(['upload_name' => 'avatar']);
			$uploaded_file = $this->upload_file(['debug' => false]);
			if(isset($uploaded_file['code']))
			{
				$file_code = $uploaded_file['code'];
				$file_id = utility\shortURL::decode($uploaded_file['code']);
				$update_user['fileid'] = $file_id;
				$user_session['file_id'] = $update_user['fileid'];
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
			$update_user['name'] = utility::post('name');
			$user_session['name'] = $update_user['name'];
		}

		// if the family exist update user display family
		if(utility::post('family') && utility::post('family') != $this->login('family'))
		{
			$update_user['lastname'] = utility::post('family');
			$user_session['family'] = $update_user['lastname'];
		}

		// if the postion exist update user display postion
		if(utility::post('post') && utility::post('post') != $this->login('postion'))
		{
			$update_user['postion'] = utility::post('post');
			$user_session['postion'] = $update_user['postion'];
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
		$request                = [];
		$request['mobile']      = $this->login('mobile');
		$request['firstname']   = utility::post('name');
		$request['lastname']    = utility::post('family');
		$request['displayname'] = utility::post('name') . ' '. utility::post('family');
		$request['postion']     = utility::post('post');
		$request['rule']        = 'admin';
		$request['file']        = $file_code;
		$request['team']        = isset($_SESSION['last_team_added_code']) ? $_SESSION['last_team_added_code'] : null;

		$team_id = \lib\utility\shortURL::decode($request['team']);
		if($team_id)
		{
			$userteam_id = \lib\db\userteams::get(['user_id' => $this->login('id'), 'team_id' => $team_id, 'limit' => 1]);
		}

	 	$userteam_id =  isset($userteam_id['id']) ? $userteam_id = $userteam_id['id'] : null;

		$request['id']          = \lib\utility\shortURL::encode($userteam_id);

		utility::set_request_array($request);
		$this->user_id      = $this->login('id');
		// API ADD MEMBER FUNCTION
		$this->add_member(['method' => 'patch']);

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