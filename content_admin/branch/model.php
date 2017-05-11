<?php
namespace content_admin\branch;
use \lib\utility;

class model extends \content_admin\main\model
{
	use \content_api\v1\branch\tools\get;
	use \content_api\v1\branch\tools\add;
	use \content_api\v1\company\tools\add;
	use \content_api\v1\company\tools\get;


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
			'brand'       => utility::post('brand'),
			'boss'        => utility::post('boss'),
			'technical'   => utility::post('technical'),
			'address'     => utility::post('address'),
			'code'        => utility::post('code'),
			'telegram_id' => utility::post('telegram_id'),
			'phone_1'     => utility::post('phone_1'),
			'phone_2'     => utility::post('phone_2'),
			'phone_3'     => utility::post('phone_3'),
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
	 * Gets the addbranch.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_addbranch($_args)
	{
		$this->user_id = $this->login('id');
		$company = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		\lib\utility::set_request_array(['company' => $company]);
		return $this->get_company();
	}


	/**
	 * Gets the list.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_listbranch($_args)
	{
		$this->user_id = $this->login('id');
		$company = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		utility::set_request_array(['company' => $company]);

		$result                = [];
		$result['company']     = $this->get_company();
		$result['branch_list'] = $this->get_list_branch();

		return $result;
	}


	/**
	 * Gets the editbranch.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_editbranch($_args)
	{
		$request            = [];
		$this->user_id      = $this->login('id');
		$request['company'] = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		$request['branch']  = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		utility::set_request_array($request);
		return $this->get_branch();
	}


	/**
	 * Posts an addbranch.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_addbranch($_args)
	{
		$request            = $this->getPost();
		$this->user_id      = $this->login('id');
		$request['company'] = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		utility::set_request_array($request);
		$this->add_branch();
	}


	/**
	 * Posts an add.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_editbranch($_args)
	{
		$request          = $this->getPost();
		$this->user_id    = $this->login('id');
		$request['company'] = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		$request['branch']  = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;

		utility::set_request_array($request);
		$this->add_branch(['method' => 'patch']);
	}


	/**
	 * Gets the branchdashboard.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_branchdashboard($_args)
	{
		$request            = [];
		$this->user_id      = $this->login('id');
		$request['company'] = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		$request['branch']  = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		utility::set_request_array($request);
		$result = $this->get_branch();
		return $result;
	}
}
?>