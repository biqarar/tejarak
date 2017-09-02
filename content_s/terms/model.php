<?php
namespace content_s\terms;
use \lib\utility;
use \lib\debug;

class model extends \content_s\main\model
{


	/**
	 * Gets the post.
	 *
	 * @return     array  The post.
	 */
	public function getPostterms()
	{
		$args =
		[
			'title' => utility::post('title'),
			'start' => utility::post('start'),
			'end'   => utility::post('end'),
			'desc'  => utility::post('desc'),
		];
		return $args;
	}



	/**
	 * Posts an add.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_terms_add($_args)
	{
		$request          = $this->getPostterms();
		if($request === false)
		{
			return false;
		}
		$this->user_id    = $this->login('id');
		$request['school'] = \lib\router::get_url(0);

		utility::set_request_array($request);
		$this->add_schoolterm();

		if(debug::$status)
		{
			$code = \lib\router::get_url(0);
			debug::msg('direct', true);
			$this->redirector()->set_domain()->set_url("s/$code/terms");
		}
	}


	/**
	 * Posts an add.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_terms_edit($_args)
	{
		$id = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;

		if(!$id)
		{
			return false;
		}

		$request          = $this->getPostterms();

		if($request === false)
		{
			return false;
		}

		$this->user_id     = $this->login('id');
		$request['id']     = $id;
		$request['school'] = \lib\router::get_url(0);

		utility::set_request_array($request);
		$this->add_schoolterm(['method' => 'patch']);

		if(debug::$status)
		{
			$code = \lib\router::get_url(0);
			debug::msg('direct', true);
			$this->redirector()->set_domain()->set_url("s/$code/terms");
		}
	}



	/**
	 * Gets the list terms.
	 */
	public function getListterms()
	{
		$this->user_id = $this->login('id');
		$request = [];
		$request['school'] = \lib\router::get_url(0);
		$request['search'] = utility::get('search');
		utility::set_request_array($request);
		$result = $this->get_list_schoolterm();
		return $result;
	}



	/**
	 * load team data to load for edit
	 *
	 * @param      <type>  $_code  The team
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function termsEdit($_terms_id)
	{
		$this->user_id = $this->login('id');
		utility::set_request_array(['id' => $_terms_id]);
		$result = $this->get_schoolterm();
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
		$this->add_schoolterm(['method' => 'patch']);
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