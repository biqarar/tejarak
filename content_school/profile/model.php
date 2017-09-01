<?php
namespace content_school\profile;
use \lib\debug;
use \lib\utility;

class model extends \content_school\main\model
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
				'input'   => utility::post(),
				'session' => $_SESSION,
			],
		];

		// update user details
		$update_user = [];
		$user_session = [];

		// check the user is login
		if(!$this->login())
		{
			debug::error(T_("Please login to change your profile"), false, 'arguments');
			return false;
		}


		// check name lenght
		if(mb_strlen(utility::post('name')) > 50)
		{
			debug::error(T_("Please enter your name less than 50 character"), 'name', 'arguments');
			return false;
		}


		// check name lenght
		if(mb_strlen(utility::post('displayname')) > 50)
		{
			debug::error(T_("Please enter your displayname less than 50 character"), 'displayname', 'arguments');
			return false;
		}


		// check name lenght
		if(mb_strlen(utility::post('family')) > 50)
		{
			debug::error(T_("Please enter your family less than 50 character"), 'family', 'arguments');
			return false;
		}

		$file_code = null;
		$temp_url  = null;
		if(utility::files('avatar'))
		{
			$this->user_id = $this->login('id');
			utility::set_request_array(['upload_name' => 'avatar']);
			$uploaded_file = $this->upload_file(['debug' => false]);

			if(isset($uploaded_file['code']))
			{
				$file_code                   = $uploaded_file['code'];
				$file_id                     = utility\shortURL::decode($uploaded_file['code']);
				$update_user['user_file_id'] = $file_id;
				$user_session['file_id']     = $update_user['user_file_id'];
			}
			if(isset($uploaded_file['url']))
			{
				$temp_url                     = $uploaded_file['url'];
				$host                         = Protocol."://" . \lib\router::get_root_domain(). '/';
				$temp_url                     = str_replace($host, '', $temp_url);
				$update_user['user_file_url'] = $temp_url;
				$user_session['file_url']     = $temp_url;
			}
			// if in upload have error return
			if(!debug::$status)
			{
				return false;
			}
		}

		// if the name exist update user display name
		if(utility::post('name') != $this->login('name'))
		{
			$update_user['user_name'] = utility::post('name');
			$user_session['name'] = $update_user['user_name'];
		}

		// if the family exist update user display family
		if(utility::post('family') != $this->login('family'))
		{
			$update_user['user_family'] = utility::post('family');
			$user_session['family'] = $update_user['user_family'];
		}

		// if the postion exist update user display postion
		if(utility::post('displayname') != $this->login('displayname'))
		{
			$update_user['user_displayname'] = utility::post('displayname');
			$user_session['displayname'] = $update_user['user_displayname'];
		}

		// $new_unit = utility::post('user-unit');

		// if($new_unit === '')
		// {
		// 	\lib\db\logs::set('user:unit:set:empty', $this->login('id'), $log_meta);
		// 	debug::error(T_("Please select one units"), 'user-unit', 'arguments');
		// 	return false;
		// }

		// if(in_array($new_unit, ['toman','dollar']))
		// {
		// 	$update_user['unit_id']  = \lib\utility\units::get_id($new_unit);
		// 	$user_session['unit_id'] = $update_user['unit_id'];
		// }
		// else
		// {
		// 	\lib\db\logs::set('user:unit:set:invalid:unit', $this->login('id'), $log_meta);
		// 	debug::error(T_("Please select a valid units"), 'user-unit', 'arguments');
		// 	return false;
		// }


		// update user record
		if(!empty($update_user))
		{

			\lib\db\users::update($update_user, $this->login('id'));
			if(isset($_SESSION['user']) && is_array($_SESSION['user']))
			{
				$_SESSION['user'] = array_merge($_SESSION['user'], $user_session);
			}
		}

		if(debug::$status)
		{
			debug::true(T_("Profile data was updated"));
			debug::msg('direct', true);
			$this->redirector()->set_domain()->set_url('a');
		}
	}

}
?>