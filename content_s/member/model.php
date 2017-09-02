<?php
namespace content_s\member;
use \lib\utility;
use \lib\debug;

class model extends \content_s\main\model
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
			'displayname'      => utility::post('name'),
			'postion'          => utility::post('postion'),
			'mobile'           => utility::post('mobile'),
			'rule'             => utility::post('rule'),
			'firstname'        => utility::post('firstName'),
			'lastname'         => utility::post('lastName'),
			'personnel_code'   => utility::post('personnelcode'),
			'allow_plus'       => utility::post('allowPlus'),
			'allow_minus'      => utility::post('allowMinus'),
			'remote_user'      => utility::post('remoteUser'),
			'24h'              => utility::post('24h'),
			'status'           => utility::post('status'),
			'visibility'       => utility::post('visibility'),
			'barcode1'         => utility::post('barcode'),
			'rfid1'            => utility::post('rfid'),
			'qrcode1'          => utility::post('qrcode'),
			'allow_desc_enter' => utility::post('allowDescEnter'),
			'allow_desc_exit'  => utility::post('allowDescExit'),
		];

		return $args;
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

		$this->user_id = $this->login('id');
		// ready request
		$request           = $this->getPost();

		$file_code = $this->upload_avatar();
		// we have an error in upload avatar
		if($file_code === false)
		{
			return false;
		}

		if($file_code)
		{
			$request['file'] = $file_code;
		}

		$team = \lib\router::get_url(0);
		// get posted data to create the request
		$request['team']  = $team;

		utility::set_request_array($request);

		// API ADD MEMBER FUNCTION
		$this->add_member();
		if(debug::$status)
		{
			$this->redirector()->set_domain()->set_url("a/$team");
		}

	}


	/**
	 * Uploads an avatar.
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function upload_avatar()
	{
		if(utility::files('avatar'))
		{
			utility::set_request_array(['upload_name' => 'avatar']);
			$uploaded_file = $this->upload_file(['debug' => false]);
			if(isset($uploaded_file['code']))
			{
				return $uploaded_file['code'];
			}
			// if in upload have error return
			if(!debug::$status)
			{
				return false;
			}
		}
		return null;
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


	/**
	 * ready to edit member
	 * load data
	 *
	 * @param      <type>  $_team    The team
	 * @param      <type>  $_member  The member
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function edit($_team, $_member)
	{
		$this->user_id    = $this->login('id');
		$request          = [];
		$request['team']  = $_team;
		$request['id']    = $_member;
		utility::set_request_array($request);
		$result           =  $this->get_member();
		$member_id        = \lib\utility\shortURL::decode($_member);
		$this->user_id    = $member_id;
		$parent           = $this->get_list_parent();
		$result['parent'] = $parent;
		return $result;
	}


	/**
	 * Posts an addmember.
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
		$file_code     = $this->upload_avatar();
		// we have an error in upload avatar
		if($file_code === false)
		{
			return false;
		}

		if($file_code)
		{
			$request['file'] = $file_code;
		}

		$url             = \lib\router::get_url();
		$member          = substr($url, strpos($url,'=') + 1);
		$request['id']   = $member;
		$request['team'] = $team = \lib\router::get_url(0);
		utility::set_request_array($request);

		// API ADD MEMBER FUNCTION
		$this->add_member(['method' => 'patch']);

		if(debug::$status)
		{
			if(utility::post('parent_mobile'))
			{
				$parent_request               = [];
				$parent_request['othertitle'] = utility::post('othertitle');
				$parent_request['title']      = utility::post('title');
				$parent_request['mobile']     = utility::post('parent_mobile');
				utility::set_request_array($parent_request);
				$this->add_parent();
			}
		}

		if(debug::$status)
		{
			$this->redirector()->set_domain()->set_url("a/$team");
		}
	}
}
?>