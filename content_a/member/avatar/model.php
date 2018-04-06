<?php
namespace content_a\member\avatar;


class model extends \content_a\member\model
{

	/**
	 * Uploads an avatar.
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function upload_avatar()
	{
		if(\dash\request::files('avatar'))
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




	/**
	 * Posts an addmember.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_avatar($_args)
	{
		$this->user_id = \lib\user::id();
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

		$member          = \dash\url::dir(3);
		$request['id']   = $member;
		$request['team'] = $team = \dash\url::dir(0);
		\lib\utility::set_request_array($request);

		// API ADD MEMBER FUNCTION
		$this->add_member(['method' => 'patch']);
		if(\lib\engine\process::status())
		{
			\lib\redirect::pwd();
		}
	}
}
?>