<?php
namespace content\home;

class controller
{

	/**
	 * the static page to not run any query
	 * and brand black list
	 * @var        array
	 */
	public static  $static_pages =
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
		// check url like this /ermile/tejarak
		if(preg_match("/^([a-zA-Z0-9]+)(|\/([a-zA-Z0-9]+))$/", \dash\url::module(), $split))
		{
			// \dash\engine\main::controller_set('content\\hours\\controller');
			return;
		}
	}
}
?>