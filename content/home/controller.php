<?php
namespace content\home;

class controller extends \content\main\controller
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

	];

	// for routing check
	function _route()
	{
		$url = \lib\router::get_url();
		// if the url in static page [and black list] return
		if(in_array($url, self::$static_pages))
		{
			return;
		}

		// check url like this /ermile/sarshomar
		if(preg_match("/^([a-zA-Z0-9]+)\/([a-zA-Z0-9]+)$/", $url, $split))
		{
			if(isset($split[1]) && isset($split[2]))
			{
				// check tema exist
				if($this->is_exist_team($split[1]))
				{
					// check branch of this team exists
					if(\lib\db\branchs::get_by_brand($split[1], $split[2]))
					{
						\lib\router::set_controller('content\\hours\\controller');
						return;
					}
				}
			}
		}

		// check url like this /ermile/sarshomar
		if(preg_match("/^([a-zA-Z0-9]+)$/", $url, $split))
		{
			if(isset($split[1]))
			{
				// check tema exist
				if($this->is_exist_team($split[1]))
				{
					\lib\router::set_controller('content\\team\\controller');
					return;
				}
			}
		}

	}


}
?>