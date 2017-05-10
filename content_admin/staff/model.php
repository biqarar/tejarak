<?php
namespace content_admin\staff;
use \lib\utility;

class model extends \content_admin\main\model
{
	use \content_api\v1\staff\tools\get;
	use \content_api\v1\staff\tools\add;


	/**
	 * Gets the list.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_liststaff($_args)
	{
		$this->user_id = $this->login('id');
		$company = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		utility::set_request_array(['company' => $company]);
		$result =  $this->get_list_staff();

		return $result;
	}


	/**
	 * Gets the addstaff.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_addstaff($_args)
	{

	}


	/**
	 * Gets the staffdashboard.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_staffdashboard($_args)
	{
		$request            = [];
		$this->user_id      = $this->login('id');
		$request['company'] = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		$request['staff']  = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		utility::set_request_array($request);
		$result = $this->get_staff();
		return $result;
	}


	/**
	 * Gets the editstaff.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_editstaff($_args)
	{
		$request            = [];
		$this->user_id      = $this->login('id');
		$request['company'] = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		$request['staff']  = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		utility::set_request_array($request);
		return $this->get_staff();
	}


	/**
	 * Posts an addstaff.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_addstaff($_args)
	{
		$request            = $this->getPost();
		$this->user_id      = $this->login('id');
		$request['company'] = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		utility::set_request_array($request);
		$this->add_staff();
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
			'title'       => utility::post('title'),
			'site'        => utility::post('site'),
			'brand'        => utility::post('brand'),
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
	 * Posts an add.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_editstaff($_args)
	{
		$request          = $this->getPost();
		$this->user_id    = $this->login('id');
		$request['company'] = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		$request['staff']  = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;

		utility::set_request_array($request);
		$this->add_staff(['method' => 'patch']);
	}
}
?>