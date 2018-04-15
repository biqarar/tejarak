<?php
namespace content\home;

class controller
{

	/**
	 * the static page to not run any query
	 * and brand black list
	 * @var        array
	 */
	public static $static_pages =
	[
		'benefits',
		'pricing',
		'help',
		'help/faq',
		'for/school',
		'admin',
		'enter',
		'about',
		'social-responsibility',
		'terms',
		'privacy',
		'changelog',
		'logo',
		'contact',
		'api',
		// brand black list
		'branch',
		'team',
		'member',
		'add',
		'edit',
		'delete',
		'user',
		'hours',
		'report',
		'last',
		'daily',
		'account',
		'for',
		'files',
		'cronjob',
		'home',
		'crontab',
		'main',
		'template',
		'hour',
	];

	// for routing check
	public static function routing()
	{
		\dash\data::tejarak_home_page(true);

		if(!in_array(\dash\url::directory(), self::$static_pages))
		{
			// check url like this /ermile/tejarak
			if(preg_match("/^([a-zA-Z0-9]+)(|\/([a-zA-Z0-9]+))$/", \dash\url::directory(), $split))
			{
				$list_member = \content\home\view::listMember();

				if($list_member)
				{
					\dash\open::get();
					\dash\open::post();

					\dash\data::tejarak_home_page(false);

					\dash\temp::set('list_member', $list_member);
				}
				elseif(\dash\temp::get('team_exist'))
				{
					\dash\header::status(403, T_("Access denied to load this team data"));
				}
			}
		}
	}
}
?>