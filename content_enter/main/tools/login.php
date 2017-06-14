<?php
namespace content_enter\main\tools;
use \lib\utility\visitor;
use \lib\utility;
use \lib\debug;
use \lib\db;

trait login
{
	/**
	 * find redirect url
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function find_redirect_url($_url = null)
	{
		if($_url)
		{
			return $_url;
		}
		// get url language
		$url = \lib\define::get_current_language_string();
		// if have referer redirect to referer
		if(utility::get('referer'))
		{
			$url = utility::get('referer');
		}
		elseif(self::get_enter_session('first_signup'))
		{
			// if first signup
			if(\lib\option::enter('singup_redirect'))
			{
				$url .= '/'. \lib\option::enter('singup_redirect');
			}
			else
			{
				$url .= \lib\option::config('redirect_url');
			}
		}
		else
		{
			$url = null;
			$user_language = \lib\utility\users::get_language(self::user_data('id'));
			if($user_language && \lib\utility\location\languages::check($user_language))
			{
				$url .= \lib\define::get_current_language_string($user_language);
			}
			else
			{
				$url .= \lib\define::get_current_language_string();
			}

			$url .= \lib\option::config('redirect_url');
		}

		return $url;
	}


	/**
	 * sync guest data to new login
	 */
	public static function sync_guest()
	{
		$old_user_id = $this->login('id');
		$new_user_id = self::user_data('id');

		if(intval($old_user_id) === intval($new_user_id))
		{
			\lib\db\logs::set('enter:guest:userid:is:guestid', self::user_data('id'), $log_meta);
			return;
		}

		\lib\utility\sync::web_guest($new_user_id, $old_user_id);
	}


	/**
	 * the gues has login
	 * logout the guest
	 * sync guset by new user
	 * login new user
	 *
	 * @param      <type>  $_url   The url
	 */
	public static function login_set_guest($_url = null)
	{
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'mobile'  => $this->mobile,
				'user_id' => self::user_data('id'),
				'input'   => utility::post(),
				'session' => $_SESSION,
			]
		];

		$user_status = \lib\utility\users::get_status(self::user_data('id'));
		switch ($user_status)
		{
			case 'active':
				\lib\db\logs::set('enter:guest:have:active:user', self::user_data('id'), $log_meta);
				break;
			case 'awaiting':
				$this->sync_guest();
				break;

			default:
				\lib\db\logs::set('enter:guest:invalid:status', self::user_data('id'), $log_meta);
				break;
		}
		// distroy guest session to set new session
		\lib\db\sessions::logout(self::user_data('id'));
		$this->put_logout();

	}


	/**
	 * login
	 */
	public static function enter_set_login($_url = null)
	{
		// if($this->is_guest)
		// {
		// 	$this->login_set_guest();
		// }
		// set session
		\lib\db\users::set_login_session(self::user_data());
		// set remeber and save session
		\lib\db\sessions::set(self::user_data('id'));
		// go to new address
		self::go_to(self::find_redirect_url($_url));
	}


	/**
	 * referer
	 *
	 * @param      array  $_args  The arguments
	 */
	public static function login_referer($_args = [])
	{
		\lib\debug::msg('direct', true);
		$url = $this->url("root");
		if(\lib\router::$prefix_base)
		{
			$url .= '/'.\lib\router::$prefix_base;
		}

		if(\lib\utility::get('referer'))
		{
			$url .= '/referer?to=' . \lib\utility::get('referer');
			$this->redirector($url)->redirect();
		}
		elseif(\lib\option::config('account', 'status'))
		{
			$url = $this->url("root");
			$_redirect_sub = \lib\option::config('redirect');

			if($_redirect_sub !== 'home')
			{
				// if(\lib\option::config('fake_sub'))
				// {
				// 	echo $this->redirector()->set_subdomain()->set_url($_redirect_sub)->redirect();
				// }
				// else
				// {
				//
				// }

				$url .= '/'. $_redirect_sub;

				if(isset($_args['user_id']) && $_args['user_id'])
				{
					$user_language = \lib\utility\users::get_language($_args['user_id']);
					if($user_language && \lib\utility\location\languages::check($user_language))
					{
						$url .= \lib\define::get_current_language_string($user_language);
					}

				}
				$this->redirector($url)->redirect();
			}
		}
		$this->redirector()->set_domain()->set_url()->redirect();
	}



	/**
	 * login whit remember
	 */
	public static function login_by_remember($_url = null)
	{
		if(\lib\db\sessions::get_cookie() && !$this->login())
		{
			$user_id = \lib\db\sessions::get_user_id();

			if($user_id)
			{
				$this->user_data = \lib\utility\users::get($user_id);
				$this->mobile    = \lib\utility\users::get_mobile($user_id);
				$this->login_set($_url);
				return true;
			}
		}
		return false;
	}
}
?>