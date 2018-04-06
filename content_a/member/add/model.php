<?php
namespace content_a\member\add;


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
			'displayname'      => \lib\request::post('name'),
			'postion'          => \lib\request::post('postion'),
			'mobile'           => \lib\request::post('mobile'),
			// 'rule'             => \lib\request::post('rule'),
			// 'firstname'        => \lib\request::post('firstName'),
			// 'lastname'         => \lib\request::post('lastName'),
			// 'personnel_code'   => \lib\request::post('personnelcode'),
			// 'allow_plus'       => \lib\request::post('allowPlus'),
			// 'allow_minus'      => \lib\request::post('allowMinus'),
			// 'remote_user'      => \lib\request::post('remoteUser'),
			// '24h'              => \lib\request::post('24h'),
			// 'status'           => \lib\request::post('status'),
			// 'visibility'       => \lib\request::post('visibility'),
			// 'barcode1'         => \lib\request::post('barcode'),
			// 'rfid1'            => \lib\request::post('rfid'),
			// 'qrcode1'          => \lib\request::post('qrcode'),
			// 'allow_desc_enter' => \lib\request::post('allowDescEnter'),
			// 'allow_desc_exit'  => \lib\request::post('allowDescExit'),
		];

		if(\lib\request::post('rule'))
		{
			$args['rule'] = \lib\request::post('rule');
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
		if(!\lib\user::login())
		{
			\lib\notif::error(T_("Please login to add a team"), false, 'arguments');
			return false;
		}

		$this->user_id = \lib\user::id();
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

		$team = \dash\url::dir(0);
		// get posted data to create the request
		$request['team']  = $team;

		\lib\utility::set_request_array($request);

		// API ADD MEMBER FUNCTION
		$this->add_member();
		if(\lib\engine\process::status())
		{
			\lib\redirect::to(\dash\url::here(). "/$team/member");
		}

	}


	/**
	 * Uploads an avatar.
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function upload_avatar()
	{
		if(\lib\request::files('avatar'))
		{
			\lib\utility::set_request_array(['upload_name' => 'avatar']);
			$uploaded_file = $this->upload_file(['debug' => false]);
			if(isset($uploaded_file['code']))
			{
				return $uploaded_file['code'];
			}
			// if in upload have error return
			if(!\lib\engine\process::status())
			{
				return false;
			}
		}
		return null;
	}

}
?>