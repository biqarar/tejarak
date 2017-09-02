<?php
namespace content_s\member\student;
use \lib\utility;
use \lib\debug;

trait model_student
{

	/**
	 * Gets the post student.
	 *
	 * @return     array  The post student.
	 */
	public function getPoststudent()
	{
		$post =
		[
			'firstname'     => utility::post('name'),
			'lastname'      => utility::post('lastName'),
			'mobile'        => utility::post('mobile'),
			'national_code' => utility::post('national-code'),
			'father'        => utility::post('father'),
			'birthday'      => utility::post('birthday'),
			'gender'        => utility::post('gender'),
		];

		return $post;
	}


	/**
	 * Posts a student add.
	 */
	public function post_student_add()
	{
		// check the user is login
		if(!$this->login())
		{
			debug::error(T_("Please login to add a team"), false, 'arguments');
			return false;
		}

		$this->user_id = $this->login('id');
		// ready request
		$request           = $this->getPoststudent();

		$file_code = $this->upload_avatar();
		// we have an error in upload avatar
		if($file_code === false)
		{
			return false;
		}

		if($file_code)
		{
			$request['file'] = $file_code;
		}

		$team = \lib\router::get_url(0);

		// get posted data to create the request
		$request['team']  = $team;
		$request['type']  = 'student';

		utility::set_request_array($request);

		// API ADD MEMBER FUNCTION
		$this->add_member();
		if(debug::$status)
		{
			$this->redirector()->set_domain()->set_url("s/$team/student");
		}
	}


	/**
	 * Gets the student list.
	 *
	 * @return     <type>  The student list.
	 */
	public function getstudentList($_meta = [])
	{
		$this->user_id   = $this->login('id');
		$request         = [];
		$team = \lib\router::get_url(0);
		$request['id']   = $team;
		$request['type'] = 'student';
		$request['hours'] = false;
		if(isset($_meta['search']))
		{
			$request['search'] = $_meta['search'];
		}

		utility::set_request_array($request);
		$result =  $this->get_list_member();
		return $result;
	}


	/**
	 * ready to edit member
	 * load data
	 *
	 * @param      <type>  $_team    The team
	 * @param      <type>  $_member  The member
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function editstudent($_team, $_member)
	{
		$this->user_id    = $this->login('id');
		$request          = [];
		$request['team']  = $_team;
		$request['id']    = $_member;
		utility::set_request_array($request);
		$result           =  $this->get_member();
		if($result)
		{
			$member_id        = \lib\utility\shortURL::decode($_member);
			$this->user_id    = $member_id;
			$parent           = $this->get_list_parent();
			$result['parent'] = $parent;
		}
		return $result;
	}


		/**
	 * Posts an addmember.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_student_edit($_args)
	{
		// check the user is login
		if(!$this->login())
		{
			return false;
		}

		$this->user_id = $this->login('id');
		$request       = $this->getPoststudent();
		$file_code     = $this->upload_avatar();
		// we have an error in upload avatar
		if($file_code === false)
		{
			return false;
		}

		if($file_code)
		{
			$request['file'] = $file_code;
		}

		$url             = \lib\router::get_url();
		$member          = substr($url, strpos($url,'=') + 1);
		$request['id']   = $member;
		$request['team'] = $team = \lib\router::get_url(0);

		utility::set_request_array($request);

		// API ADD MEMBER FUNCTION
		$this->add_member(['method' => 'patch']);

		if(debug::$status)
		{
			if(utility::post('parent_mobile'))
			{
				$parent_request               = [];
				$parent_request['othertitle'] = utility::post('othertitle');
				$parent_request['title']      = utility::post('title');
				$parent_request['mobile']     = utility::post('parent_mobile');
				utility::set_request_array($parent_request);
				$this->add_parent();
			}
		}

		if(debug::$status)
		{
			$this->redirector()->set_domain()->set_url("s/$team/student");
		}
	}

}
?>