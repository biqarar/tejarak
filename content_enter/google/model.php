<?php
namespace content_enter\google;
use \lib\debug;
use \lib\utility;
use \lib\social\google;

class model extends \content_enter\main\model
{
	public function get_google()
	{
		if(utility::get('code'))
		{
			// check access from google
			$check = google::check();
			if($check)
			{
				// go to what url
				$go_to_url = null;

				$user_data = google::user_info();
				// get user email
				$self::$email = google::user_info('email');
				// load data by email
				self::load_user_data('email');
				// the user exist in system
				if(self::user_data('id'))
				{
					// check user status
					if(in_array(self::user_data('user_status'), self::$block_status))
					{
						// the user was blocked
						self::next_step('block');
						// go to block page
						self::go_to('block');

						return false;
					}
					else
					{
						if(self::user_data('user_mobile'))
						{
							// no problem to login this user
						}
						else
						{
							self::set_enter_session('mobile_request_from', 'google_email_exist');
							// go to mobile get to enter mobile
							self::next_step('mobile/request');
							// get go to url
							$go_to_url = 'mobile/request';
						}
					}
				}
				else
				{
					// new user signup by email
					$args = [];
					if(google::user_info('name'))
					{
						$args['displayname'] = google::user_info('name');
					}
					elseif(google::user_info('familyName') || google::user_info('givenName'))
					{
						$args['displayname'] = trim(google::user_info('familyName'). ' '. google::user_info('givenName'));
					}

					$args['user_google_mail'] = google::user_info('email');

					self::set_enter_session('mobile_request_from', 'google_email_not_exist');

					self::set_enter_session('must_signup', $args);

					// $user_id = self::signup($args);
					// // save user data in socials table
					// \lib\db\socials::google_save($user_id, google::user_info());

					// go to mobile get to enter mobile
					self::next_step('mobile/request');
					// get go to url
					$go_to_url = 'mobile/request';
				}

				// set login session
				$redirect_url = self::enter_set_login();
				self::set_enter_session('redirect_url', $redirect_url);
				// go to url
				if($go_to_url)
				{
					self::go_to($go_to_url);
				}
				else
				{
					// save redirect url in session to get from okay page
					// set okay as next step
					self::next_step('okay');
					// go to okay page
					self::go_to('okay');
				}

			}
			else
			{
				return false;
			}
		}
	}
}
?>