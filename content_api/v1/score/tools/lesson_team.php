<?php
namespace content_api\v1\score\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait lesson_team
{
	public function check_teams_of_lesson($_args)
	{
		// request
		// 'school'        = 'RHd' ;
		// 'user_id'       = 'bwQH' ;
		// 'type'          = 'score' ;
		// 'lesson_id'     = 'b' ;

		// args
		// 'school_id'     = '100068' ;
		// 'classroom'     = '100071' ;
		// 'schoolterm_id' = '2' ;
		// 'teacher'       = '1000834' ;
		// 'subject_id'    = '1' ;
		// 'student'       = '1000836' ;
		// 'start'         = '2017-09-04 16:54:56' ;
		// 'creator'       = '4' ;

		$lesson_id = utility\shortURL::decode(utility::request('lesson_id'));
		$get_lesson_team = \lib\db\teams::get(['related' => 'school_lessons', 'related_id' => $lesson_id, 'type' => 'lesson', 'limit' => 1]);
		$old_request = utility::request();
		if(!isset($get_lesson_team['id']))
		{
			$classroom_detail = \lib\db\teams::get(['id' => $_args['classroom'], 'limit' => 1]);

			// insert new teams as the lesson
			$insert_team_request = [];
			// get the lesson name
			$lesson_team_name                  = \lib\db\school_lessons::make_team_lesson_name($lesson_id);

			$insert_team_request['name']       = $lesson_team_name;
			$insert_team_request['short_name'] = md5((string) $lesson_id. (string) time());;
			$insert_team_request['type']       = 'lesson';
			$insert_team_request['parent']     =  isset($classroom_detail['id']) ? utility\shortURL::encode($classroom_detail['id']) : null;;

			// $insert_team_request['website']           = null;
			// $insert_team_request['desc']              = null;
			// $insert_team_request['show_avatar']       = null;
			// $insert_team_request['allow_plus']        = null;
			// $insert_team_request['allow_minus']       = null;
			// $insert_team_request['remote_user']       = null;
			// $insert_team_request['24h']               = null;
			// $insert_team_request['logo']              = null;
			// $insert_team_request['privacy']           = null;
			// $insert_team_request['language']          = null;
			// $insert_team_request['event_title']       = null;
			// $insert_team_request['event_date']        = null;
			// $insert_team_request['manual_time_exit']  = null;
			// $insert_team_request['manual_time_enter'] = null;
			// $insert_team_request['send_photo']        = null;
			// $insert_team_request['cardsize']          = null;
			// $insert_team_request['allow_desc_enter']  = null;
			// $insert_team_request['allow_desc_exit']   = null;


			utility::set_request_array($insert_team_request);

			$this->add_team(['related' => 'school_lessons', 'related_id' => $lesson_id, 'auto_insert_userteam' => false, 'debug' => false]);

			$lesson_team_id = \lib\storage::get_last_team_id_added();

			$lesson_team_code = \lib\utility\shortURL::encode($lesson_team_id);

			utility::set_request_array($old_request);

			if($lesson_team_id && debug::$status)
			{
				$teacher = $_args['teacher'];
				$teacher_user_id = \lib\db\userteams::get(['id' => $teacher, 'limit' => 1]);
				if(isset($teacher_user_id['user_id']))
				{

					$userteam_request_teacher['team']        = $lesson_team_code;
					$userteam_request_teacher['displayname'] = isset($teacher_user_id['displayname']) ? $teacher_user_id['displayname'] : null;
					$userteam_request_teacher['firstname']   = isset($teacher_user_id['firstname']) ? $teacher_user_id['firstname'] : null;
					$userteam_request_teacher['lastname']    = isset($teacher_user_id['lastname']) ? $teacher_user_id['lastname'] : null;
					$userteam_request_teacher['rule']        = 'admin';
					$userteam_request_teacher['type']        = 'score_student';

					utility::set_request_array($userteam_request_teacher);

					$this->add_member(['have_user_id' => $teacher_user_id['user_id'], 'debug' => false]);

					utility::set_request_array($old_request);
					// $userteam_request_teacher['mobile']           = null;
					// $userteam_request_teacher['id']               = null;
					// $userteam_request_teacher['visibility']       = null;
					// $userteam_request_teacher['postion']          = null;
					// $userteam_request_teacher['personnel_code']   = null;
					// $userteam_request_teacher['status']           = null;
					// $userteam_request_teacher['allow_plus']       = null;
					// $userteam_request_teacher['allow_minus']      = null;
					// $userteam_request_teacher['24h']              = null;
					// $userteam_request_teacher['remote_user']      = null;
					// $userteam_request_teacher['is_default']       = null;
					// $userteam_request_teacher['allow_desc_enter'] = null;
					// $userteam_request_teacher['allow_desc_exit']  = null;
					// $userteam_request_teacher['date_enter']       = null;
					// $userteam_request_teacher['date_exit']        = null;
					// $userteam_request_teacher['file']             = null;
					// $userteam_request_teacher['national_code']    = null;
					// $userteam_request_teacher['father']           = null;
					// $userteam_request_teacher['birthday']         = null;
					// $userteam_request_teacher['gender']           = null;

				}

			}
		}
		else
		{
			$lesson_team_id = $get_lesson_team['id'];
			$lesson_team_code = \lib\utility\shortURL::encode($lesson_team_id);
		}


		$student = $_args['student'];
		$student_user_id = \lib\db\userteams::get(['id' => $student, 'limit' => 1]);
		if(isset($student_user_id['user_id']))
		{

			$userteam_request_student['team']        = $lesson_team_code;
			$userteam_request_student['displayname'] = isset($student_user_id['displayname']) ? $student_user_id['displayname'] : null;
			$userteam_request_student['firstname']   = isset($student_user_id['firstname']) ? $student_user_id['firstname'] : null;
			$userteam_request_student['lastname']    = isset($student_user_id['lastname']) ? $student_user_id['lastname'] : null;
			$userteam_request_student['rule']        = 'user';
			$userteam_request_student['type']        = 'score_student';

			utility::set_request_array($userteam_request_student);

			$this->add_member(['have_user_id' => $student_user_id['user_id'], 'debug' => false]);

			utility::set_request_array($old_request);
			// $userteam_request_student['mobile']           = null;
			// $userteam_request_student['id']               = null;
			// $userteam_request_student['visibility']       = null;
			// $userteam_request_student['postion']          = null;
			// $userteam_request_student['personnel_code']   = null;
			// $userteam_request_student['status']           = null;
			// $userteam_request_student['allow_plus']       = null;
			// $userteam_request_student['allow_minus']      = null;
			// $userteam_request_student['24h']              = null;
			// $userteam_request_student['remote_user']      = null;
			// $userteam_request_student['is_default']       = null;
			// $userteam_request_student['allow_desc_enter'] = null;
			// $userteam_request_student['allow_desc_exit']  = null;
			// $userteam_request_student['date_enter']       = null;
			// $userteam_request_student['date_exit']        = null;
			// $userteam_request_student['file']             = null;
			// $userteam_request_student['national_code']    = null;
			// $userteam_request_student['father']           = null;
			// $userteam_request_student['birthday']         = null;
			// $userteam_request_student['gender']           = null;
		}
	}


	public function check_teams_of_lesson_update($_args, $_update_type)
	{
		$lesson_id = utility\shortURL::decode(utility::request('lesson_id'));
		$get_lesson_team = \lib\db\teams::get(['related' => 'school_lessons', 'related_id' => $lesson_id, 'type' => 'lesson', 'limit' => 1]);
		if(isset($get_lesson_team['id']))
		{
			$lesson_team_id = $get_lesson_team['id'];
			$lesson_team_code = \lib\utility\shortURL::encode($lesson_team_id);
		}
		else
		{
			return false;
		}

		$old_request = utility::request();

		$student = $_args['student'];
		$student_user_id = \lib\db\userteams::get(['id' => $student, 'limit' => 1]);
		if(isset($student_user_id['user_id']))
		{

			$userteam_request_student['team']   = $lesson_team_code;
			$userteam_request_student['status'] = $_update_type;

			utility::set_request_array($userteam_request_student);

			$this->add_member(['have_user_id' => $student_user_id['user_id'], 'debug' => false, 'method' => 'patch']);

			utility::set_request_array($old_request);
			// $userteam_request_student['mobile']           = null;
			// $userteam_request_student['id']               = null;
			// $userteam_request_student['visibility']       = null;
			// $userteam_request_student['postion']          = null;
			// $userteam_request_student['personnel_code']   = null;
			// $userteam_request_student['status']           = null;
			// $userteam_request_student['allow_plus']       = null;
			// $userteam_request_student['allow_minus']      = null;
			// $userteam_request_student['24h']              = null;
			// $userteam_request_student['remote_user']      = null;
			// $userteam_request_student['is_default']       = null;
			// $userteam_request_student['allow_desc_enter'] = null;
			// $userteam_request_student['allow_desc_exit']  = null;
			// $userteam_request_student['date_enter']       = null;
			// $userteam_request_student['date_exit']        = null;
			// $userteam_request_student['file']             = null;
			// $userteam_request_student['national_code']    = null;
			// $userteam_request_student['father']           = null;
			// $userteam_request_student['birthday']         = null;
			// $userteam_request_student['gender']           = null;
		}

	}
}
?>