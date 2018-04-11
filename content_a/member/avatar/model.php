<?php
namespace content_a\member\avatar;


class model
{

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




	/**
	 * Posts an addmember.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function post()
	{
		$file_code     = self::upload_avatar();

		// we have an error in upload avatar
		if($file_code === false)
		{
			\dash\notif::error(T_("Can not upload file"));
			return false;
		}

		if($file_code)
		{
			$request['file'] = $file_code;
		}

		$member          = \dash\request::get('member');
		$request['id']   = $member;
		$request['team'] = \dash\request::get('id');
		\dash\app::variable($request);

		// API ADD MEMBER FUNCTION
		\lib\app\member::add_member(['method' => 'patch']);

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>