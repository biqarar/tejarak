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
				$user_data = google::user_info();

				$self::$email = google::user_info('email');

				self::load_user_data('email');

				if(self::user_data('id'))
				{
					if(self::user_data('user_mobile'))
					{

					}
					else
					{
						// go to get mobile page
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

					self::signup($args);
				}
				// set login session
				$redirect_url = self::enter_set_login();

				// save redirect url in session to get from okay page
				self::set_enter_session('redirect_url', $redirect_url);
				// set okay as next step
				self::next_step('okay');
				// go to okay page
				self::go_to('okay');

			}
			else
			{
				return false;
			}
		}
	}
}
?>