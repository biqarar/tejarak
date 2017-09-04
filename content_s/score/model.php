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
		$team_short_name = utility\shortURL::decode($_lessonid);
		$team_short_name = md5($team_short_name);
		$request['shortname'] = $team_short_name;

		// to get last hours. what i want to do?
		utility::set_request_array($request);
		$result =  $this->get_list_member(['admin' => true]);

		return $result;
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
		$request = [];

		$request['school']    = \lib\router::get_url(0);
		$request['user_id']   = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		$request['type']      = utility::post('type');
		$request['lesson_id'] = utility::post('id');
		utility::set_request_array($request);
		$this->user_id        = $this->login('id');

		$this->score();

		if(debug::$status)
		{
			$this->redirector($this->url('full'));
		}

	}
}
?>