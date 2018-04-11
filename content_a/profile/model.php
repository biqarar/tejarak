<?php
namespace content_a\profile;


class model
{
	/**
	 * Posts a setup 2.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public static function post()
	{

		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input'   => \dash\request::post(),
				'session' => $_SESSION,
			],
		];

		// update user details
		$update_user = [];
		$user_session = [];

		// check the user is login
		if(!\dash\user::login())
		{
			\dash\notif::error(T_("Please login to change your profile"), false, 'arguments');
			return false;
		}


		// check name lenght
		if(mb_strlen(\dash\request::post('name')) > 50)
		{
			\dash\notif::error(T_("Please enter your name less than 50 character"), 'name', 'arguments');
			return false;
		}


		// check name lenght
		if(mb_strlen(\dash\request::post('displayname')) > 50)
		{
			\dash\notif::error(T_("Please enter your displayname less than 50 character"), 'displayname', 'arguments');
			return false;
		}


		// check name lenght
		if(mb_strlen(\dash\request::post('family')) > 50)
		{
			\dash\notif::error(T_("Please enter your family less than 50 character"), 'family', 'arguments');
			return false;
		}

		$file_code = null;
		$temp_url  = null;
		if(\dash\request::files('avatar'))
		{

			$uploaded_file = \dash\app\file::upload(['debug' => false, 'upload_name' => 'avatar']);

			if(isset($uploaded_file['url']))
			{
				$temp_url                = $uploaded_file['url'];
				$host                    = \dash\url::site().'/';
				$temp_url                = str_replace($host, '', $temp_url);
				$update_user['avatar']  = $temp_url;
				$user_session['avatar'] = $temp_url;
			}
			// if in upload have error return
			if(!\dash\engine\process::status())
			{
				return false;
			}
		}


		// if the postion exist update user display postion
		if(\dash\request::post('displayname') != \dash\user::login('displayname'))
		{
			$update_user['displayname'] = \dash\request::post('displayname');
			$user_session['displayname'] = $update_user['displayname'];
		}


		// update user record
		if(!empty($update_user))
		{

			\dash\db\users::update($update_user, \dash\user::id());
			if(isset($_SESSION['user']) && is_array($_SESSION['user']))
			{
				$_SESSION['user'] = array_merge($_SESSION['user'], $user_session);
			}
		}

		if(\dash\engine\process::status())
		{
			\dash\notif::ok(T_("Profile data was updated"));
			\dash\notif::direct();
			\dash\redirect::pwd();
		}
	}

}
?>