<?php
namespace content_admin\team;
use \lib\utility;

class model extends \content_admin\main\model
{


	/**
	 * Gets the post.
	 *
	 * @return     array  The post.
	 */
	public function getPost()
	{
		$args =
		[
			'title'           => utility::post('title'),
			'site'            => utility::post('site'),
			'brand'           => utility::post('brand'),
			'register_code'   => utility::post('register_code'),
			'economical_code' => utility::post('economical_code'),
		];
		return $args;
	}


	/**
	 * Posts an add.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_add($_args)
	{
		$request          = $this->getPost();
		$this->user_id    = $this->login('id');
		utility::set_request_array($request);
		$this->add_team();
	}


	/**
	 * Gets the list.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_list($_args)
	{
		$this->user_id = $this->login('id');
		$result =  $this->get_list_team();
		return $result;
	}

	/**
	 * load team data to load for edit
	 *
	 * @param      <type>  $_team  The team
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function edit($_team)
	{
		$this->user_id = $this->login('id');
		utility::set_request_array(['team' => $_team]);
		return $this->get_team();
	}


	/**
	 * Posts an add.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_edit($_args)
	{
		$request         = $this->getPost();
		$this->user_id   = $this->login('id');
		$request['team'] = $this->view()->find_team_name_url($_args);
		utility::set_request_array($request);
		$this->add_team(['method' => 'patch']);
	}


	/**
	 * Posts a delete.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function post_delete($_args)
	{
		utility::set_request_array(['brand' => utility::post('brand')]);
		$this->user_id = $this->login('id');
		return $this->delete_team();
	}
}
?>