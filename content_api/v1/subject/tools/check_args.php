<?php
namespace content_api\v1\subject\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait check_args
{
	public function subject_check_args($_args, &$args, $log_meta)
	{
		// get firsttitle
		$title = utility::request("title");
		$title = trim($title);
		if($title && mb_strlen($title) > 50)
		{
			logs::set('api:subject:title:max:length', $this->user_id, $log_meta);
			debug::error(T_("You can set the title less than 50 character"), 'title', 'arguments');
			return false;
		}

		if(!$title)
		{
			logs::set('api:subject:title:empty', $this->user_id, $log_meta);
			debug::error(T_("Title of lesson can not be null"), 'title', 'arguments');
			return false;
		}

		$desc = utility::request("desc");
		$desc = trim($desc);
		if($desc && mb_strlen($desc) > 1000)
		{
			logs::set('api:subject:desc:max:length', $this->user_id, $log_meta);
			debug::error(T_("You can set the desc less than 1000 character"), 'desc', 'arguments');
			return false;
		}

		$category = utility::request('category');
		if($category && mb_strlen($category) > 50)
		{
			logs::set('api:subject:category:max:length', $this->user_id, $log_meta);
			debug::error(T_("You must set the subject category less than 50 character"), 'category', 'arguments');
			return false;
		}

		$status = utility::request('status');
		if($status && !in_array($status, ['enable', 'disable']))
		{
			logs::set('api:subject:status:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid subject status"), 'status', 'arguments');
			return false;
		}

		// ready to insert userschool or userbranch record

		$args['title']     = $title;
		$args['desc']      = $desc;
		$args['status']    = $status;
		$args['category']  = $category;

	}
}
?>