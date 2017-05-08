<?php
namespace content_api\v1\company\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;
trait add
{
	public function add_company($_args = [])
	{
		debug::title(T_("Operation Faild"));
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => utility::request(),
			]
		];

		$title = utility::request('title');

		if(mb_strlen($title) > 500)
		{
			logs::set('api:company:maxlength:title', $this->user_id, $log_meta);
			debug::error(T_("Company title must be less than 500 character"), 'title', 'arguments');
			return false;
		}

		$site = utility::request('site');
		if(mb_strlen($site) > 1000)
		{
			logs::set('api:company:maxlength:site', $this->user_id, $log_meta);
			debug::error(T_("Company site must be less than 1000 character"), 'site', 'arguments');
			return false;
		}


		$check_duplicate_title = ['creator' => $this->user_id, 'title' => $title, 'get_count' => true];
		$check = \lib\db\companies::search(null, $check_duplicate_title);
		if($check)
		{
			logs::set('api:company:duplocate:title', $this->user_id, $log_meta);
			debug::error(T_("Duplicate title of company"), 'title', 'arguments');
			return false;
		}

		$args            = [];
		$args['creator'] = $this->user_id;
		$args['title']   = $title;
		$args['site']    = $site;

		\lib\db\companies::insert($args);

		if(debug::$status)
		{
			debug::title(T_("Operation Complete"));
			debug::true("Comany added");
		}
		else
		{
			debug::error(T_("Error in adding company"));
		}

	}
}
?>