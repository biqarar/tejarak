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
			\dash\app::variable(['upload_name' => 'avatar']);
			$uploaded_file = $this->upload_file(['debug' => false]);
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
	public function post_avatar($_args)
	{
		$this->user_id = \dash\user::id();
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
		$request['team'] = $team = \dash\request::get('id');
		\dash\app::variable($request);

		// API ADD MEMBER FUNCTION
		$this->add_member(['method' => 'patch']);
		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>