<?php
namespace content_api\v1\subject\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait add
{


	/**
	 * Adds a subject.
	 *
	 * @param      array    $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function add_subject($_args = [])
	{
		// default args
		$default_args =
		[
			'method' => 'post'
		];

		if(!is_array($_args))
		{
			$_args = [];
		}
		// merge default args and args
		$_args = array_merge($default_args, $_args);

		// set default title of debug
		debug::title(T_("Operation Faild"));

		// delete subject mode
		$delete_mode = false;

		// set the log meta
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => utility::request(),
			]
		];

		// check user id is exist
		if(!$this->user_id)
		{
			logs::set('api:subject:user_id:notfound', $this->user_id, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		// get school and check it
		$school = utility::request('school');
		$school = utility\shortURL::decode($school);
		if(!$school)
		{
			logs::set('api:subject:school:not:set', $this->user_id, $log_meta);
			debug::error(T_("School not set"), 'user', 'permission');
			return false;
		}
		// load school data
		$school_detail = \lib\db\teams::access_team_id($school, $this->user_id, ['action' => 'add_school_subject']);
		// check the school exist
		if(isset($school_detail['id']))
		{
			$school_id = $school_detail['id'];
		}
		else
		{
			logs::set('api:subject:school:notfound:invalid', $this->user_id, $log_meta);
			debug::error(T_("school not found"), 'user', 'permission');
			return false;
		}

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

		// ready to insert userschool or userbranch record
		$args              = [];
		$args['school_id'] = $school_id;
		$args['title']     = $title;
		$args['desc']      = $desc;


		if($_args['method'] === 'post')
		{
			\lib\db\school_subjects::insert($args);
		}
		elseif($_args['method'] === 'patch')
		{
			$id = utility::request('id');
			$id = utility\shortURL::decode($id);
			if(!$id)
			{
				logs::set('api:subject:pathc:id:not:set', $this->user_id, $log_meta);
				debug::error(T_("Id not set"), 'id', 'arguments');
				return false;
			}

			$check_user_in_school = \lib\db\school_subjects::get(['id' => $id, 'school_id' => $school_id, 'limit' => 1]);

			if(!$check_user_in_school || !isset($check_user_in_school['id']))
			{
				logs::set('api:subject:user:not:in:school', $this->user_id, $log_meta);
				debug::error(T_("This user is not in this school"), 'id', 'arguments');
				return false;
			}

			unset($args['school_id']);

			if(!utility::isset_request('title')) 		unset($args['title']);
			if(!utility::isset_request('desc')) 		unset($args['desc']);

			if(!empty($args))
			{
				\lib\db\school_subjects::update($args, $check_user_in_school['id']);
			}


		}
		elseif ($_args['method'] === 'delete')
		{
			// \lib\db\school_subjects::remove($args);
		}

		if(debug::$status)
		{
			debug::title(T_("Operation Complete"));

			if($_args['method'] === 'post')
			{
				debug::true(T_("Subject successfully added"));
			}
			elseif($_args['method'] === 'patch')
			{
				debug::true(T_("Subject successfully updated"));
			}
			else
			{
				debug::true(T_("Subject successfully removed"));
			}
		}

	}
}
?>