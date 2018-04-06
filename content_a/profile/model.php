<?php
namespace content_a\profile;


class model extends \content_a\main\model
{
	/**
	 * Posts a setup 2.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_profile($_args)
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
			$this->user_id = \dash\user::id();
			\dash\utility::set_request_array(['upload_name' => 'avatar']);
			$uploaded_file = $this->upload_file(['\lib\notif' => false]);

			if(isset($uploaded_file['url']))
			{
				$temp_url                = $uploaded_file['url'];
				$host                    = \dash\url::site().'/';
				$temp_url                = str_replace($host, '', $temp_url);
				$update_user['avatar']  = $temp_url;
				$user_session['avatar'] = $temp_url;
			}
			// if in upload have error return
			if(!\lib\engine\process::status())
			{
				return false;
			}
		}

		// // if the name exist update user display name
		// if(\dash\request::post('name') != \dash\user::login('name'))
		// {
		// 	$update_user['name'] = \dash\request::post('name');
		// 	$user_session['name'] = $update_user['name'];
		// }

		// // if the family exist update user display family
		// if(\dash\request::post('family') != \dash\user::login('family'))
		// {
		// 	$update_user['lastname'] = \dash\request::post('family');
		// 	$user_session['family'] = $update_user['lastname'];
		// }

		// if the postion exist update user display postion
		if(\dash\request::post('displayname') != \dash\user::login('displayname'))
		{
			$update_user['displayname'] = \dash\request::post('displayname');
			$user_session['displayname'] = $update_user['displayname'];
		}

		// $new_unit = \dash\request::post('user-unit');

		// if($new_unit === '')
		// {
		// 	\dash\db\logs::set('user:unit:set:empty', \dash\user::id(), $log_meta);
		// 	\dash\notif::error(T_("Please select one units"), 'user-unit', 'arguments');
		// 	return false;
		// }

		// if(in_array($new_unit, ['toman','dollar']))
		// {
		// 	$update_user['unit_id']  = \dash\app\units::get_id($new_unit);
		// 	$user_session['unit_id'] = $update_user['unit_id'];
		// }
		// else
		// {
		// 	\dash\db\logs::set('user:unit:set:invalid:unit', \dash\user::id(), $log_meta);
		// 	\dash\notif::error(T_("Please select a valid units"), 'user-unit', 'arguments');
		// 	return false;
		// }


		// update user record
		if(!empty($update_user))
		{

			\dash\db\users::update($update_user, \dash\user::id());
			if(isset($_SESSION['user']) && is_array($_SESSION['user']))
			{
				$_SESSION['user'] = array_merge($_SESSION['user'], $user_session);
			}
		}

		if(\lib\engine\process::status())
		{
			\dash\notif::ok(T_("Profile data was updated"));
			\dash\notif::direct();
			\dash\redirect::pwd();
		}
	}

}
?>