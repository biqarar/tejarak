<?php
namespace content_s\score;
use \lib\debug;
use \lib\utility;

class model extends \content_s\main\model
{


	/**
	 * ready to edit member
	 * load data
	 *
	 * @param      <type>  $_team    The team
	 * @param      <type>  $_member  The member
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function loadClassMember($_lessonid)
	{
		$this->user_id   = $this->login('id');
		$request         = [];
		$lesson_id       = utility\shortURL::decode($_lessonid);
		$get_team_lesson = \lib\db\teams::get(['related' => 'school_lessons', 'related_id' => $lesson_id, 'limit' => 1]);

		if(isset($get_team_lesson['shortname']))
		{
			$request['shortname'] = $get_team_lesson['shortname'];
			utility::set_request_array($request);
			$result =  $this->get_list_member(['admin' => true]);
			return $result;
		}
	}


	/**
	 * Loads a taken unit.
	 *
	 * @param      <type>  $_member  The member
	 */
	public function loadscore($_member)
	{
		$this->user_id      = $this->login('id');
		$request            = [];
		$request['school']  = \lib\router::get_url(0);
		$request['student'] = $_member;
		$request['term']    = null;
		utility::set_request_array($request);
		$result           =  $this->get_list_score();
		return $result;
	}


	/**
	 * laod all lesson active in thie school
	 *
	 * @param      <type>  $_school_code  The school code
	 */
	public function loadLesson($_school_code)
	{
		$this->user_id   = $this->login('id');
		$request         = [];
		$request['school'] = \lib\router::get_url(0);
		utility::set_request_array($request);
		$result           =  $this->get_list_lesson();
		return $result;
	}


	/**
	 * post a taken unit and set the userlesson
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_score($_args)
	{
		$this->user_id        = $this->login('id');
		$request              = [];
		$request['student']   = utility::post('id');
		$request['date']      = utility\human::number(utility::post('date'), 'en');
		$request['type']      = utility::post('type');
		$request['score']     = utility::post('score');
		$request['school']    = \lib\router::get_url(0);
		$request['lesson_id'] = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;

		utility::set_request_array($request);

		$this->add_score();

		if(debug::$status)
		{
			$this->redirector($this->url('full'));
		}

	}
}
?>