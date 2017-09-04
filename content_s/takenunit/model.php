<?php
namespace content_s\takenunit;
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
	public function loadPanel($_member)
	{
		$this->user_id   = $this->login('id');
		$request         = [];
		$request['team'] = \lib\router::get_url(0);
		$request['id']   = $_member;
		$request['type'] = 'student';
		utility::set_request_array($request);
		$result           =  $this->get_member();
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
	public function post_takenunit($_args)
	{
		$request = [];

		$request['school_id'] = \lib\router::get_url(0);
		$request['user_id']   = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		$request['type']      = utility::post('type');
		$request['lesson_id'] = utility::post('id');

		$this->user_id        = $this->login('id');

		// $this->add_takenunit();

		if(debug::$status)
		{
			$this->redirector($this->url('full'));
		}

	}
}
?>