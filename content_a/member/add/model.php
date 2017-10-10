<?php
namespace content_a\member\add;
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
			'displayname'      => utility::post('name'),
			'postion'          => utility::post('postion'),
			'mobile'           => utility::post('mobile'),
			// 'rule'             => utility::post('rule'),
			// 'firstname'        => utility::post('firstName'),
			// 'lastname'         => utility::post('lastName'),
			// 'personnel_code'   => utility::post('personnelcode'),
			// 'allow_plus'       => utility::post('allowPlus'),
			// 'allow_minus'      => utility::post('allowMinus'),
			// 'remote_user'      => utility::post('remoteUser'),
			// '24h'              => utility::post('24h'),
			// 'status'           => utility::post('status'),
			// 'visibility'       => utility::post('visibility'),
			// 'barcode1'         => utility::post('barcode'),
			// 'rfid1'            => utility::post('rfid'),
			// 'qrcode1'          => utility::post('qrcode'),
			// 'allow_desc_enter' => utility::post('allowDescEnter'),
			// 'allow_desc_exit'  => utility::post('allowDescExit'),
		];

		if(utility::post('rule'))
		{
			$args['rule'] = utility::post('rule');
		}

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
			$this->redirector()->set_domain()->set_url("a/$team/member");
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

}
?>