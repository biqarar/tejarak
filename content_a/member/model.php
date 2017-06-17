<?php
namespace content_a\member;
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
			'mobile'         => utility::post('mobile'),
			'name'           => utility::post('name'),
			'family'         => utility::post('family'),
			'mobile'         => utility::post('mobile'),
			'postion'        => utility::post('postion'),
			'code'           => utility::post('code'),
			// 'telegram_id' => utility::post('telegram_id'),
			'full_time'      => utility::post('full_time'),
			'remote'         => utility::post('remote'),
			'is_default'     => utility::post('is_default'),
			// 'date_enter'  => utility::post('date_enter'),
			// 'date_exit'   => utility::post('date_exit'),
			'status'         => utility::post('status'),
		];
		return $args;
	}


	/**
	 * Gets the addmember.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_add($_args)
	{
		$request         = [];
		$this->user_id   = $this->login('id');
		$request['team'] = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		utility::set_request_array($request);
		$result = $this->get_team();
		return $result;

	}


	/**
	 * Posts an addmember.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_add($_args)
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

		// get posted data to create the request
		$request           = $this->getPost();
		$request['team']   = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		$request['branch'] = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		$request['file']   = $file_code;
		$this->user_id     = $this->login('id');
		utility::set_request_array($request);
		// API ADD MEMBER FUNCTION
		$this->add_member();
	}


	/**
	 * Gets the list.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function list_member($_args)
	{
		$this->user_id     = $this->login('id');
		$request           = [];
		$request['team']   = isset($_args['team']) ? $_args['team'] : null;
		$request['branch'] = isset($_args['branch']) ? $_args['branch'] : null;
		utility::set_request_array($request);
		$result =  $this->get_list_member();
		return $result;
	}




// OLD CODE ************************************************************************************




	/**
	 * Gets the memberdashboard.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_memberdashboard($_args)
	{
		$request            = [];
		$this->user_id      = $this->login('id');
		$request['team'] = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		$request['member']  = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		utility::set_request_array($request);
		$result = $this->get_member();
		return $result;
	}


	/**
	 * Gets the editmember.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_editmember($_args)
	{
		$request            = [];
		$this->user_id      = $this->login('id');
		$request['team'] = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		$request['member']  = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		utility::set_request_array($request);
		return $this->get_member();
	}





	/**
	 * Posts an add.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_editmember($_args)
	{
		$request          = $this->getPost();
		$this->user_id    = $this->login('id');
		$request['team'] = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		$request['member']  = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;

		utility::set_request_array($request);
		$this->add_member(['method' => 'patch']);
	}


	/**
	 * Gets the editmember team.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_editmember_team($_args)
	{
		$userteam_id = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		utility::set_request_array(['id' => $userteam_id]);
		$this->user_id = $this->login('id');
		$result = $this->userteam_get_details();
		// var_dump($result);
		return $result;

	}


	/**
	 * Gets the editmember team.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_editmember_team($_args)
	{
		$this->user_id      = $this->login('id');
		$userteam_id     = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		$request            = $this->getPost();
		$request['id']      = $userteam_id;
		$request['team'] = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		utility::set_request_array($request);
		$result = $this->add_member(['method' => 'patch']);
		// var_dump($result);
		return $result;

	}
}
?>