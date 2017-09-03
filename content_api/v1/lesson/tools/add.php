<?php
namespace content_api\v1\lesson\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait add
{


	/**
	 * Adds a lesson.
	 *
	 * @param      array    $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function add_lesson($_args = [])
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

		// delete lesson mode
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
			logs::set('api:lesson:user_id:notfound', $this->user_id, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		// get school and check it
		$school = utility::request('school');
		$school = utility\shortURL::decode($school);
		if(!$school)
		{
			logs::set('api:lesson:school:not:set', $this->user_id, $log_meta);
			debug::error(T_("School not set"), 'user', 'permission');
			return false;
		}
		// load school data
		$school_detail = \lib\db\teams::access_team_id($school, $this->user_id, ['action' => 'add_school_lesson']);
		// check the school exist
		if(isset($school_detail['id']))
		{
			$school_id = $school_detail['id'];
		}
		else
		{
			logs::set('api:lesson:school:notfound:invalid', $this->user_id, $log_meta);
			debug::error(T_("school not found"), 'user', 'permission');
			return false;
		}


		$terms = utility::request('terms');
		$terms = utility\shortURL::decode($terms);
		if(!$terms)
		{
			logs::set('api:lesson:terms:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid terms id"));
			return false;
		}

		$classroom = utility::request('classroom');
		$classroom = utility\shortURL::decode($classroom);
		if(!$terms)
		{
			logs::set('api:lesson:classroom:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid classroom id"));
			return false;
		}

		$subject = utility::request('subject');
		$subject = utility\shortURL::decode($subject);
		if(!$terms)
		{
			logs::set('api:lesson:subject:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid subject id"));
			return false;
		}

		$teacher = utility::request('teacher');
		$teacher = utility\shortURL::decode($teacher);
		if(!$terms)
		{
			logs::set('api:lesson:teacher:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid teacher id"));
			return false;
		}

		$desc      = utility::request('desc');

		$start     = utility::request('start');
		$end       = utility::request('end');


		// ready to insert userschool or userbranch record
		$args                  = [];
		$args['school_id']     = $school_id;
		$args['schoolterm_id'] = $terms;
		$args['subject_id']    = $subject;
		$args['place_id']      = $classroom;
		$args['teacher']       = $teacher;
		$args['desc']          = $desc;
		$args['creator']       = $this->user_id;

		if($_args['method'] === 'post')
		{
			\lib\db\lessons::insert($args);
		}
		elseif($_args['method'] === 'patch')
		{
			$id = utility::request('id');
			$id = utility\shortURL::decode($id);
			if(!$id)
			{
				logs::set('api:lesson:pathc:id:not:set', $this->user_id, $log_meta);
				debug::error(T_("Id not set"), 'id', 'arguments');
				return false;
			}

			$check_user_in_school = \lib\db\lessons::get(['id' => $id, 'school_id' => $school_id, 'limit' => 1]);

			if(!$check_user_in_school || !isset($check_user_in_school['id']))
			{
				logs::set('api:lesson:user:not:in:school', $this->user_id, $log_meta);
				debug::error(T_("This user is not in this school"), 'id', 'arguments');
				return false;
			}

			unset($args['school_id']);

			if(!utility::isset_request('title')) 		unset($args['title']);
			if(!utility::isset_request('desc')) 		unset($args['desc']);

			if(!empty($args))
			{
				\lib\db\lessons::update($args, $check_user_in_school['id']);
			}


		}
		elseif ($_args['method'] === 'delete')
		{
			// \lib\db\lessons::remove($args);
		}

		if(debug::$status)
		{
			debug::title(T_("Operation Complete"));

			if($_args['method'] === 'post')
			{
				debug::true(T_("lesson successfully added"));
			}
			elseif($_args['method'] === 'patch')
			{
				debug::true(T_("lesson successfully updated"));
			}
			else
			{
				debug::true(T_("lesson successfully removed"));
			}
		}

	}
}
?>