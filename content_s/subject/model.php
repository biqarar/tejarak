<?php
namespace content_s\subject;
use \lib\utility;
use \lib\debug;

class model extends \content_s\main\model
{


	/**
	 * Gets the post.
	 *
	 * @return     array  The post.
	 */
	public function getPostsubject()
	{
		$args =
		[
			'title' => utility::post('title'),
			'desc'  => utility::post('desc'),
		];
		return $args;
	}



	/**
	 * Posts an add.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_subject_add($_args)
	{
		$request          = $this->getPostsubject();
		if($request === false)
		{
			return false;
		}
		$this->user_id    = $this->login('id');
		$request['school'] = \lib\router::get_url(0);

		utility::set_request_array($request);
		$this->add_subject();

		if(debug::$status)
		{
			$code = \lib\router::get_url(0);
			debug::msg('direct', true);
			$this->redirector()->set_domain()->set_url("s/$code/subject");
		}
	}


	/**
	 * Posts an add.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_subject_edit($_args)
	{
		$id = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;

		if(!$id)
		{
			return false;
		}

		$request          = $this->getPostsubject();

		if($request === false)
		{
			return false;
		}

		$this->user_id     = $this->login('id');
		$request['id']     = $id;
		$request['school'] = \lib\router::get_url(0);

		utility::set_request_array($request);
		$this->add_subject(['method' => 'patch']);

		if(debug::$status)
		{
			$code = \lib\router::get_url(0);
			debug::msg('direct', true);
			$this->redirector()->set_domain()->set_url("s/$code/subject");
		}
	}



	/**
	 * Gets the list subject.
	 */
	public function getListsubject()
	{
		$this->user_id = $this->login('id');
		$request = [];
		$request['school'] = \lib\router::get_url(0);
		$request['search'] = utility::get('search');
		utility::set_request_array($request);
		$result = $this->get_list_subject();
		return $result;
	}



	/**
	 * load team data to load for edit
	 *
	 * @param      <type>  $_code  The team
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function subjectEdit($_subject_id)
	{
		$this->user_id = $this->login('id');
		utility::set_request_array(['id' => $_subject_id]);
		$result = $this->get_subject();

		return $result;
	}


	/**
	 * Posts an add.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_edit($_args)
	{
		$code = \lib\router::get_url(0);

		// if delete link is clicked
		// go to delete function and return
		if(utility::post('delete'))
		{
			$this->post_close();
			return;
		}

		$request       = $this->getPost();

		if($request === false)
		{
			return false;
		}

		$this->user_id = $this->login('id');
		$request['id'] = $code;

		utility::set_request_array($request);

		// THE API ADD TEAM FUNCTION BY METHOD PATHC
		$this->add_team(['method' => 'patch']);
		if(debug::$status)
		{
			debug::msg('direct', true);
			$this->redirector()->set_domain()->set_url("s/$code");
		}
	}


	/**
	 *
	 * Posts a delete.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function post_close()
	{
		$code = \lib\router::get_url(0);
		$this->user_id = $this->login('id');
		utility::set_request_array(['id' => $code]);
		$this->close_team();
		if(debug::$status)
		{
			debug::msg('direct', true);
			$this->redirector()->set_domain()->set_url('s');
		}
	}
}
?>