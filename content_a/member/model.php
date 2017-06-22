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
			'name'           => utility::post('name'),
			'postion'        => utility::post('postion'),
			'mobile'         => utility::post('mobile'),
			'rule'           => utility::post('rule'),
			'firstname'      => utility::post('firstName'),
			'lastname'       => utility::post('lastName'),
			'personnel_code' => utility::post('personnelcode'),
			'allow_plus'     => utility::post('allowPlus'),
			'allow_minus'    => utility::post('allowMinus'),
			'remote_user'    => utility::post('remoteUser'),
			'24h'            => utility::post('24h'),
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
		$this->user_id = $this->login('id');
		// ready request
		$request           = $this->getPost();

		$file_code = null;
		if(utility::files('avatar'))
		{
			utility::set_request_array(['upload_name' => 'avatar']);
			$uploaded_file = $this->upload_file(['debug' => false]);
			if(isset($uploaded_file['code']))
			{
				$request['fileid'] = $uploaded_file['code'];
			}
			// if in upload have error return
			if(!debug::$status)
			{
				return false;
			}
		}

		$team = \lib\router::get_url(1);
		// get posted data to create the request
		$request['id']  = $team;

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
		$this->user_id = $this->login('id');
		$request       = [];
		$request['id'] = isset($_args['id']) ? $_args['id'] : null;
		utility::set_request_array($request);
		$result =  $this->get_list_member();
		return $result;
	}

}
?>