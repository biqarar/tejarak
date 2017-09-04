<?php
namespace content_api\v1\score\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait add
{
	// use lesson_team;

	// the classed time id
	public $classes_time_id = [];


	/**
	 * Adds a lesson.
	 *
	 * @param      array    $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function add_score($_args = [])
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
			logs::set('api:score:user_id:notfound', $this->user_id, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		// get school and check it
		$school = utility::request('school');
		$school = utility\shortURL::decode($school);
		if(!$school)
		{
			logs::set('api:score:school:not:set', $this->user_id, $log_meta);
			debug::error(T_("School not set"), 'user', 'permission');
			return false;
		}
		// load school data
		$school_detail = \lib\db\teams::access_team_id($school, $this->user_id, ['action' => 'admin']);

		// check the school exist
		if(isset($school_detail['id']))
		{
			$school_id = $school_detail['id'];
		}
		else
		{
			logs::set('api:score:school:notfound:invalid', $this->user_id, $log_meta);
			debug::error(T_("School not found"), 'user', 'permission');
			return false;
		}

		$user_id = utility::request('user_id');
		$user_id = utility\shortURL::decode($user_id);
		if(!$user_id)
		{
			logs::set('api:score:user_id:not:set', $this->user_id, $log_meta);
			debug::error(T_("User id not set"), 'user', 'permission');
			return false;
		}

		$check_user_in_school = \lib\db\teams::access_team_id($school, $user_id, ['action' => 'in_team']);

		// check the school exist
		if(isset($check_user_in_school['userteam_id']))
		{
			$user_in_school = $check_user_in_school['userteam_id'];
		}
		else
		{
			logs::set('api:score:school:notfound:invalid', $this->user_id, $log_meta);
			debug::error(T_("This user in not in this school"), 'user', 'permission');
			return false;
		}

		$type = utility::request('type');
		if(!in_array($type, ['score', 'removeunit']))
		{
			logs::set('api:score:type:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid type"), 'type', 'permission');
			return false;
		}

		$lesson_id = utility::request('lesson_id');
		$lesson_id = utility\shortURL::decode($lesson_id);
		if(!$lesson_id)
		{
			logs::set('api:score:lesson_id:not:set', $this->user_id, $log_meta);
			debug::error(T_("Lesson id not set"), 'user', 'permission');
			return false;
		}


		$lesson_detail = \lib\db\school_lessons::get(['id' => $lesson_id, 'limit' => 1]);

		if
		(
			!isset($lesson_detail['school_id']) ||
			!isset($lesson_detail['status']) ||
			!isset($lesson_detail['classroom']) ||
			!isset($lesson_detail['schoolterm_id']) ||
			!isset($lesson_detail['subject_id']) ||
			!isset($lesson_detail['teacher'])
		)
		{
			logs::set('api:score:lesson_detail:not:found', $this->user_id, $log_meta);
			debug::error(T_("Lesson detail not found"), 'lesson_id', 'permission');
			return false;
		}

		if($lesson_detail['status'] !== 'enable')
		{
			logs::set('api:score:lesson_detail:status:is:not:enable', $this->user_id, $log_meta);
			debug::error(T_("The lesson is not enable"), 'lesson_id', 'permission');
			return false;
		}

		if(intval($lesson_detail['school_id']) !== intval($school))
		{
			logs::set('api:score:lesson_detail:from:another:school', $this->user_id, $log_meta);
			debug::error(T_("This lesson is not enable in your school"), 'lesson_id', 'permission');
			return false;
		}

		$check_takedunit =
		[
			'school_id'     => $lesson_detail['school_id'],
			'classroom'     => $lesson_detail['classroom'],
			'schoolterm_id' => $lesson_detail['schoolterm_id'],
			'teacher'       => $lesson_detail['teacher'],
			'subject_id'    => $lesson_detail['subject_id'],
			'lesson_id'     => $lesson_id,
			'student'       => $user_in_school,
			'limit'         => 1,
		];

		$check_takedunit = \lib\db\school_userlessons::get($check_takedunit);

		$must_insert_school_userlesson_record = true;
		$must_update_school_userlesson_record = false;

		if(isset($check_takedunit['id']) && isset($check_takedunit['status']) && $type === 'score')
		{
			if($check_takedunit['status'] === 'enable')
			{
				logs::set('api:score:lesson_detail:from:another:school', $this->user_id, $log_meta);
				debug::error(T_("This lesson added to this user before"), 'lesson_id', 'permission');
				return false;
			}
			else
			{
				$must_insert_school_userlesson_record = false;
				$must_update_school_userlesson_record = true;
			}
		}

		// ready to insert userschool or userbranch record
		$args                  = [];
		$args['school_id']     = $lesson_detail['school_id'];
		$args['classroom']     = $lesson_detail['classroom'];
		$args['schoolterm_id'] = $lesson_detail['schoolterm_id'];
		$args['teacher']       = $lesson_detail['teacher'];
		$args['subject_id']    = $lesson_detail['subject_id'];
		$args['lesson_id']     = $lesson_id;
		$args['student']       = $user_in_school;
		$args['start']         = date("Y-m-d H:i:s");
		$args['creator']       = $this->user_id;


		if($_args['method'] === 'post' && $type === 'score')
		{
			if($must_insert_school_userlesson_record)
			{
				\lib\db\school_userlessons::insert($args);
				$this->check_teams_of_lesson($args);
			}

			if($must_update_school_userlesson_record)
			{
				$this->check_teams_of_lesson_update($args, 'active');
				\lib\db\school_userlessons::update(['status' => 'enable'], $check_takedunit['id']);
			}

		}
		elseif($_args['method'] === 'post' && $type === 'removeunit')
		{
			$this->check_teams_of_lesson_update($args, 'deactive');

			if(isset($check_takedunit['id']))
			{
				\lib\db\school_userlessons::update(['status' => 'disable'], $check_takedunit['id']);
			}
		}

		if(debug::$status)
		{
			debug::title(T_("Operation Complete"));

			if($type === 'score')
			{
				debug::true(T_("lesson successfully added"));
			}
			elseif($type === 'removeunit')
			{
				debug::true(T_("lesson successfully removed"));
			}
			else
			{
				debug::true(T_("lesson successfully updated"));
			}
		}

	}
}
?>