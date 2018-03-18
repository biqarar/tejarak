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
				'input'   => \lib\request::post(),
				'session' => $_SESSION,
			],
		];

		// update user details
		$update_user = [];
		$user_session = [];

		// check the user is login
		if(!\lib\user::login())
		{
			\lib\notif::error(T_("Please login to change your profile"), false, 'arguments');
			return false;
		}


		// check name lenght
		if(mb_strlen(\lib\request::post('name')) > 50)
		{
			\lib\notif::error(T_("Please enter your name less than 50 character"), 'name', 'arguments');
			return false;
		}


		// check name lenght
		if(mb_strlen(\lib\request::post('displayname')) > 50)
		{
			\lib\notif::error(T_("Please enter your displayname less than 50 character"), 'displayname', 'arguments');
			return false;
		}


		// check name lenght
		if(mb_strlen(\lib\request::post('family')) > 50)
		{
			\lib\notif::error(T_("Please enter your family less than 50 character"), 'family', 'arguments');
			return false;
		}

		$file_code = null;
		$temp_url  = null;
		if(\lib\request::files('avatar'))
		{
			$this->user_id = \lib\user::id();
			\lib\utility::set_request_array(['upload_name' => 'avatar']);
			$uploaded_file = $this->upload_file(['\lib\notif' => false]);

			if(isset($uploaded_file['url']))
			{
				$temp_url                = $uploaded_file['url'];
				$host                    = \lib\url::site().'/';
				$temp_url                = str_replace($host, '', $temp_url);
				$update_user['avatar']  = $temp_url;
				$user_session['avatar'] = $temp_url;
			}
			// if in upload have error return
			if(!\lib\notif::$status)
			{
				return false;
			}
		}

		// // if the name exist update user display name
		// if(\lib\request::post('name') != \lib\user::login('name'))
		// {
		// 	$update_user['name'] = \lib\request::post('name');
		// 	$user_session['name'] = $update_user['name'];
		// }

		// // if the family exist update user display family
		// if(\lib\request::post('family') != \lib\user::login('family'))
		// {
		// 	$update_user['lastname'] = \lib\request::post('family');
		// 	$user_session['family'] = $update_user['lastname'];
		// }

		// if the postion exist update user display postion
		if(\lib\request::post('displayname') != \lib\user::login('displayname'))
		{
			$update_user['displayname'] = \lib\request::post('displayname');
			$user_session['displayname'] = $update_user['displayname'];
		}

		// $new_unit = \lib\request::post('user-unit');

		// if($new_unit === '')
		// {
		// 	\lib\db\logs::set('user:unit:set:empty', \lib\user::id(), $log_meta);
		// 	\lib\notif::error(T_("Please select one units"), 'user-unit', 'arguments');
		// 	return false;
		// }

		// if(in_array($new_unit, ['toman','dollar']))
		// {
		// 	$update_user['unit_id']  = \lib\utility\units::get_id($new_unit);
		// 	$user_session['unit_id'] = $update_user['unit_id'];
		// }
		// else
		// {
		// 	\lib\db\logs::set('user:unit:set:invalid:unit', \lib\user::id(), $log_meta);
		// 	\lib\notif::error(T_("Please select a valid units"), 'user-unit', 'arguments');
		// 	return false;
		// }


		// update user record
		if(!empty($update_user))
		{

			\lib\db\users::update($update_user, \lib\user::id());
			if(isset($_SESSION['user']) && is_array($_SESSION['user']))
			{
				$_SESSION['user'] = array_merge($_SESSION['user'], $user_session);
			}
		}

		if(\lib\notif::$status)
		{
			\lib\notif::true(T_("Profile data was updated"));
			\lib\notif::direct();
			\lib\redirect::pwd();
		}
	}

}
?>