<?php
namespace content_admin\branch;
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
			'title'       => utility::post('title'),
			'site'        => utility::post('site'),
			// 'brand'       => utility::post('brand'),
			// 'boss'        => utility::post('boss'),
			// 'technical'   => utility::post('technical'),
			'address'     => utility::post('address'),
			'code'        => utility::post('code'),
			// 'telegram_id' => utility::post('telegram_id'),
			'phone_1'     => utility::post('phone_1'),
			// 'phone_2'     => utility::post('phone_2'),
			// 'phone_3'     => utility::post('phone_3'),
			'fax'         => utility::post('fax'),
			'email'       => utility::post('email'),
			'post_code'   => utility::post('post_code'),
			'full_time'   => utility::post('full_time'),
			'remote'      => utility::post('remote'),
			'is_default'  => utility::post('is_default'),
		];
		return $args;
	}


	/**
	 * add new branch
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_add($_args)
	{
		$request         = $this->getPost();
		$this->user_id   = $this->login('id');
		$team            = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		$request['team'] = $team;
		utility::set_request_array($request);
		$this->add_branch();
	}


	/**
	 * Gets the editbranch.
	 * load data of branch to edit it
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function edit($_args)
	{
		$request           = [];
		$this->user_id     = $this->login('id');
		$request['team']   = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		$request['branch'] = $_args->get('branch')[0];
		utility::set_request_array($request);
		return $this->get_branch();
	}


	/**
	 * Posts an add.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_edit($_args)
	{
		$request           = $this->getPost();
		$this->user_id     = $this->login('id');
		$request['team']   = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		$request['branch'] = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;

		utility::set_request_array($request);
		$this->add_branch(['method' => 'patch']);
	}


	/**
	 * get list of branch of team
	 *
	 * @param      <type>  $_team  The team
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function branch_list($_team)
	{
		if($this->login())
		{
			$this->user_id = $this->login('id');
			utility::set_request_array(['team' => $_team]);
			return $this->get_list_branch();
		}
	}

}
?>