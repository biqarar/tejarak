<?php
namespace content\contact;


class model
{
	/**
	 * save contact form
	 */
	public static function post()
	{
		// check login
		if(\dash\user::login())
		{
			$user_id = \dash\user::id();

			// get mobile from user login session
			$mobile = \dash\user::login('mobile');

			if(!$mobile)
			{
				$mobile = \dash\request::post('mobile');
			}

			// get display name from user login session
			$displayname = \dash\user::login("displayname");
			// user not set users display name, we get display name from contact form
			if(!$displayname)
			{
				$displayname = \dash\request::post("name");
			}
			// get email from user login session
			$email = \dash\db\users::get_email($user_id);
			// user not set users email, we get email from contact form
			if(!$email)
			{
				$email = \dash\request::post("email");
			}
		}
		else
		{
			// users not registered
			$user_id     = null;
			$displayname = \dash\request::post("name");
			$email       = \dash\request::post("email");
			$mobile      = \dash\request::post("mobile");
		}
		// get the content
		$content = \dash\request::post("content");

		// save log meta
		$log_meta =
		[
			'meta' =>
			[
				'login'    => \dash\user::login('all'),
				'language' => \dash\language::current(),
				'post'     => \dash\request::post(),
			]
		];

		// check content
		if($content == '')
		{
			\dash\db\logs::set('user:send:contact:empty:message', $user_id, $log_meta);
			\dash\notif::error(T_("Please try type something!"), "content");
			return false;
		}
		// ready to insert comments
		$args =
		[
			'author'  => $displayname,
			'email'   => $email,
			'type'    => 'comment',
			'content' => $content,
			'user_id'         => $user_id
		];
		// insert comments
		$result = \dash\db\comments::insert($args);
		if($result)
		{
			// $mail =
			// [
			// 	'to'      => 'info@tejarak.com',
			// 	'subject' => 'contact',
			// 	'body'    => $content,
			// ];
			// \dash\mail::send($mail);

			\dash\db\logs::set('user:send:contact', $user_id, $log_meta);
			\dash\notif::ok(T_("Thank You For contacting us"));
		}
		else
		{
			\dash\db\logs::set('user:send:contact:fail', $user_id, $log_meta);
			\dash\notif::error(T_("We could'nt save the contact"));
		}
	}
}