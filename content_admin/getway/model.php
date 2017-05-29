<?php
namespace content_admin\getway;
use \lib\utility;

class model extends \content_admin\main\model
{


	/**
	 * Loads a company.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function load_company($_args)
	{
		$this->user_id = $this->login('id');
		$company = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		\lib\utility::set_request_array(['company' => $company]);
		return $this->get_company();
	}


	/**
	 * Loads a branch.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function load_branch($_args)
	{
		$request            = [];
		$this->user_id      = $this->login('id');
		$request['company'] = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		$request['branch']  = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		utility::set_request_array($request);
		$result = $this->get_branch();
		return $result;
	}


	/**
	 * Gets the list.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_listgetway($_args)
	{
		$this->user_id = $this->login('id');
		$company       = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		$branch        = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		utility::set_request_array(['company' => $company, 'branch' => $branch]);
		$result        =  $this->get_list_getway();
		return $result;
	}


	/**
	 * Gets the addgetway.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_addgetway($_args)
	{

	}


	/**
	 * Gets the getwaydashboard.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_getwaydashboard($_args)
	{
		$request            = [];
		$this->user_id      = $this->login('id');
		$request['company'] = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		$request['getway']  = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		utility::set_request_array($request);
		$result = $this->get_getway();
		return $result;
	}


	/**
	 * Gets the editgetway.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_editgetway($_args)
	{
		$request            = [];
		$this->user_id      = $this->login('id');
		$request['company'] = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		$request['getway']  = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		$request['id']      = isset($_args->match->url[0][3]) ? $_args->match->url[0][3] : null;
		utility::set_request_array($request);
		return $this->get_getway();
	}


	/**
	 * Posts an addgetway.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_addgetway($_args)
	{
		$request            = $this->getPost();
		$this->user_id      = $this->login('id');
		$request['company'] = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		$request['branch']  = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		utility::set_request_array($request);
		$this->add_getway();
	}


	/**
	 * Gets the post.
	 *
	 * @return     array  The post.
	 */
	public function getPost()
	{
		$args =
		[
			'title'  => utility::post('title'),
			'cat'    => utility::post('cat'),
			'code'   => utility::post('code'),
			'ip'     => utility::post('ip'),
			'status' => utility::post('status'),
			'desc'   => utility::post('desc'),
		];
		return $args;
	}


	/**
	 * Posts an add.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_editgetway($_args)
	{
		$request            = $this->getPost();
		$this->user_id      = $this->login('id');
		$request['company'] = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		$request['branch']  = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		$request['id']      = isset($_args->match->url[0][3]) ? $_args->match->url[0][3] : null;

		utility::set_request_array($request);
		$this->add_getway(['method' => 'patch']);
	}

}
?>