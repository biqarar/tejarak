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
		$lesson_id = utility::request('lesson_id');
		$lesson_id = utility\shortURL::decode($lesson_id);
		if(!$lesson_id)
		{
			logs::set('api:score:lesson_id:not:set', $this->user_id, $log_meta);
			debug::error(T_("lesson_id not set"), 'user', 'permission');
			return false;
		}
		// // load lesson_id data
		// $lesson_id_detail = \lib\db\teams::access_team_id($lesson_id, $this->user_id, ['action' => 'admin']);

		// // check the school exist
		// if(isset($school_detail['id']))
		// {
		// 	$school_id = $school_detail['id'];
		// }
		// else
		// {
		// 	logs::set('api:score:school:notfound:invalid', $this->user_id, $log_meta);
		// 	debug::error(T_("School not found"), 'user', 'permission');
		// 	return false;
		// }

		$student = utility::request('student');
		$student = utility\shortURL::decode($student);
		if(!$student)
		{
			logs::set('api:score:student:not:set', $this->user_id, $log_meta);
			debug::error(T_("Studnet id not set"), 'user', 'permission');
			return false;
		}

		$student_user_id = \lib\db\userteams::get(['id' => $student, 'limit' => 1]);
		if(isset($student_user_id['user_id']))
		{
			$student_user_id = $student_user_id['user_id'];
		}
		else
		{
			$student_user_id = null;
		}

		$lesson_team_detail = \lib\db\teams::get(['related' => 'school_lessons', 'related_id' => $lesson_id, 'limit' => 1]);
		if(isset($lesson_team_detail['id']))
		{
			$tema_id = $lesson_team_detail['id'];
		}
		else
		{
			$tema_id = null;
		}

		$check_user_in_lesson = \lib\db\teams::access_team_id($tema_id, $student_user_id, ['action' => 'in_team']);

		// check the school exist
		if(isset($check_user_in_lesson['userteam_id']))
		{
			$user_in_school = $check_user_in_lesson['userteam_id'];
		}
		else
		{
			logs::set('api:score:school:notfound:invalid', $this->user_id, $log_meta);
			debug::error(T_("This user in not in this school"), 'user', 'permission');
			return false;
		}

		$type = utility::request('type');
		if(!in_array($type, ['default','classroom','endterm']))
		{
			logs::set('api:score:type:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid type"), 'type', 'permission');
			return false;
		}

		$date = utility::request('date');
		if(!$date)
		{
			logs::set('api:score:date:not:set:invalid', $this->user_id, $log_meta);
			debug::error(T_("Date not set"), 'date', 'permission');
			return false;
		}
		if(strtotime($date) === false)
		{
			logs::set('api:score:date:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid date"), 'date', 'permission');
			return false;
		}
		$date = date("Y-m-d H:i:s", strtotime($date));

		$score = utility::request('score');
		if(!$score)
		{
			logs::set('api:score:score:not:set:invalid', $this->user_id, $log_meta);
			debug::error(T_("score not set"), 'score', 'permission');
			return false;
		}

		if(!is_numeric($score))
		{
			logs::set('api:score:score:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid score"), 'score', 'permission');
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

		$check_takedunit =
		[
			'school_id'     => $lesson_detail['school_id'],
			'classroom'     => $lesson_detail['classroom'],
			'schoolterm_id' => $lesson_detail['schoolterm_id'],
			'teacher'       => $lesson_detail['teacher'],
			'subject_id'    => $lesson_detail['subject_id'],
			'lesson_id'     => $lesson_id,
			'date'          => $date,
			'student'       => $student,
			'limit'         => 1,
		];

		$check_takedunit = \lib\db\school_scores::get($check_takedunit);

		if(isset($check_takedunit['id']))
		{
			logs::set('api:score:lesson_detail:from:another:school', $this->user_id, $log_meta);
			debug::error(T_("This score added to this user before"), 'lesson_id', 'permission');
			return false;
		}

		// ready to insert userschool or userbranch record
		$args                  = [];
		$args['school_id']     = $lesson_detail['school_id'];
		$args['classroom']     = $lesson_detail['classroom'];
		$args['schoolterm_id'] = $lesson_detail['schoolterm_id'];
		$args['teacher']       = $lesson_detail['teacher'];
		$args['subject_id']    = $lesson_detail['subject_id'];
		$args['lesson_id']     = $lesson_id;
		$args['student']       = $student;
		$args['date']          = $date;
		$args['score']         = $score;
		$args['creator']       = $this->user_id;


		if($_args['method'] === 'post')
		{
			\lib\db\school_scores::insert($args);
		}
		elseif($_args['method'] === 'post' && $type === 'removeunit')
		{
			$this->check_teams_of_lesson_update($args, 'deactive');

			if(isset($check_takedunit['id']))
			{
				\lib\db\school_scores::update(['status' => 'disable'], $check_takedunit['id']);
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