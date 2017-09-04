<?php
namespace content_api\v1\takenunit\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait get
{


	/**
	 * ready data of team to load in api
	 *
	 * @param      <type>  $_data  The data
	 */
	public function ready_takeunit($_data, $_options = [])
	{
		$default_options =
		[
			'check_is_my_team' => true,
		];

		if(!is_array($_options))
		{
			$_options = [];
		}

		$_options = array_merge($default_options, $_options);

		$result = [];
		foreach ($_data as $key => $value)
		{
			switch ($key)
			{

				case 'id':
				case 'school_id':
				case 'schoolterm_id':
				case 'teacher':
				case 'subject_id':
				case 'creator':
				case 'lesson_id':
				case 'classroom_id':
					$result[$key] = utility\shortURL::encode($value);
					break;

				case 'classroom':
				case 'desc':
				case 'meta':
				case 'createdate':
				case 'date_modified':
					continue;
					break;

				case 'status':
				case 'schoolterm_start':
				case 'schoolterm_end':
				case 'schoolterm_title':
				case 'classroom':
				case 'teacher_name':
				case 'teacher_family':
				case 'subject_title':
				default:
					$result[$key] = $value;
					break;
			}
		}

		return $result;
	}



	/**
	 * Gets the team.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The team.
	 */
	public function get_list_takenunit($_args = [])
	{
		if(!$this->user_id)
		{
			return false;
		}

		$log_meta =
		[
			'meta' =>
			[
				'request' => utility::request(),
			],
		];

		$meta = [];
		$school_id = utility::request('school');
		$school_id = \lib\utility\shortURL::decode($school_id);
		if(!$school_id || !is_numeric($school_id))
		{
			logs::set('api:lesson:get:list:school_id:invalid', $this->user_id);
			debug::error(T_("Invalid school id"), 'school', 'arguments');
			return false;
		}



		$user_id = utility::request('student');
		$user_id = utility\shortURL::decode($user_id);
		if(!$user_id)
		{
			logs::set('api:takenunit:user_id:not:set', $this->user_id, $log_meta);
			debug::error(T_("User id not set"), 'user', 'permission');
			return false;
		}

		$check_user_in_school = \lib\db\teams::access_team_id($school_id, $user_id, ['action' => 'in_team']);

		// check the school exist
		if(isset($check_user_in_school['userteam_id']))
		{
			$user_in_school = $check_user_in_school['userteam_id'];
		}
		else
		{
			logs::set('api:takenunit:school:notfound:invalid', $this->user_id, $log_meta);
			debug::error(T_("This user in not in this school"), 'user', 'permission');
			return false;
		}


		$term = utility::request('term');
		$term = utility\shortURL::decode($term);
		if(!$term && utility::request('term'))
		{
			logs::set('api:takenunit:term:invalid:not:set', $this->user_id, $log_meta);
			debug::error(T_("Invalid term id"), 'user', 'permission');
			return false;
		}

		// invalid school id
		if(intval($check_user_in_school['id']) !== intval($school_id))
		{
			logs::set('api:takenunit:term:invalid:schoolid:not:set', $this->user_id, $log_meta);
			debug::error(T_("Invalid school data"), 'school', 'permission');
			return false;
		}

		$meta              = [];
		$meta['school_userlessons.school_id'] = $school_id;
		$meta['school_userlessons.student']   = $user_in_school;
		if($term)
		{
			$meta['school_userlessons.schoolterm_id'] = $term;
		}

		$search = null;
		$result = \lib\db\school_userlessons::search($search, $meta);

		$temp = [];
		if(is_array($result))
		{
			foreach ($result as $key => $value)
			{
				$check = $this->ready_takeunit($value);
				if($check)
				{
					$temp[] = $check;
				}
			}
		}

		return $temp;
	}



	/**
	 * Gets the team.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The team.
	 */
	public function get_takenunit($_options = [])
	{
		$default_options =
		[
			'debug' => true,
		];

		if(!is_array($_options))
		{
			$_options = [];
		}

		$_options = array_merge($default_options, $_options);

		if($_options['debug'])
		{
			debug::title(T_("Operation Faild"));
		}

		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => utility::request(),
			]
		];

		if(!$this->user_id)
		{
			return false;
		}

		$id = utility::request("id");

		$id = \lib\utility\shortURL::decode($id);

		if(!$id)
		{
			if($_options['debug'])
			{
				logs::set('api:lesson:id:shortname:not:set', $this->user_id, $log_meta);
				debug::error(T_("Team id or shortname not set"), 'id', 'arguments');
			}
			return false;
		}

		$result = \lib\db\school_lessons::get_lesson(['id' => $id, 'limit' => 1]);

		if(!$result)
		{
			logs::set('api:lesson:access:denide', $this->user_id, $log_meta);
			if($_options['debug'])
			{
				debug::error(T_("Can not access to load this lesson details"), 'lesson', 'permission');
			}
			return false;
		}

		if($_options['debug'])
		{
			debug::title(T_("Operation complete"));
		}

		$result = $this->ready_lesson($result);

		$this->get_lesson_times($result);

		return $result;
	}

}
?>