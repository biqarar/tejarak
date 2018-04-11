<?php
namespace content_a\member\add;


class model
{

	/**
	 * Gets the post.
	 *
	 * @return     array  The post.
	 */
	public static function getPost()
	{
		$args =
		[
			'displayname'      => \dash\request::post('name'),
			'postion'          => \dash\request::post('postion'),
			'mobile'           => \dash\request::post('mobile'),
			// 'rule'             => \dash\request::post('rule'),
			// 'firstname'        => \dash\request::post('firstName'),
			// 'lastname'         => \dash\request::post('lastName'),
			// 'personnel_code'   => \dash\request::post('personnelcode'),
			// 'allow_plus'       => \dash\request::post('allowPlus'),
			// 'allow_minus'      => \dash\request::post('allowMinus'),
			// 'remote_user'      => \dash\request::post('remoteUser'),
			// '24h'              => \dash\request::post('24h'),
			// 'status'           => \dash\request::post('status'),
			// 'visibility'       => \dash\request::post('visibility'),
			// 'barcode1'         => \dash\request::post('barcode'),
			// 'rfid1'            => \dash\request::post('rfid'),
			// 'qrcode1'          => \dash\request::post('qrcode'),
			// 'allow_desc_enter' => \dash\request::post('allowDescEnter'),
			// 'allow_desc_exit'  => \dash\request::post('allowDescExit'),
		];

		if(\dash\request::post('rule'))
		{
			$args['rule'] = \dash\request::post('rule');
		}

		return $args;
	}


	/**
	 * Posts an addmember.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function post()
	{
		// check the user is login
		if(!\dash\user::login())
		{
			\dash\notif::error(T_("Please login to add a team"), false, 'arguments');
			return false;
		}
		$request           = self::getPost();

		$file_code = self::upload_avatar();
		// we have an error in upload avatar
		if($file_code === false)
		{
			return false;
		}

		if($file_code)
		{
			$request['file'] = $file_code;
		}

		$team = \dash\request::get('id');
		// get posted data to create the request
		$request['team']  = $team;

		\dash\app::variable($request);

		// API ADD MEMBER FUNCTION
		\lib\app\member::add_member();

		if(\dash\engine\process::status())
		{
			\dash\redirect::to(\dash\url::here(). "/member?id=". \dash\request::get('id'));
		}

	}


	/**
	 * Uploads an avatar.
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function upload_avatar()
	{
		if(\dash\request::files('avatar'))
		{
			\dash\app::variable(['upload_name' => 'avatar']);
			$uploaded_file = \dash\app\file::upload(['debug' => false]);
			if(isset($uploaded_file['code']))
			{
				return $uploaded_file['code'];
			}
			// if in upload have error return
			if(!\dash\engine\process::status())
			{
				return false;
			}
		}
		return null;
	}

}
?>