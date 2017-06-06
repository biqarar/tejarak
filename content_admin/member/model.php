<?php
namespace content_admin\member;
use \lib\utility;
use \lib\debug;

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
			'name'        => utility::post('name'),
			'family'      => utility::post('family'),
			'mobile'      => utility::post('mobile'),
			'postion'     => utility::post('postion'),
			'code'        => utility::post('code'),
			'telegram_id' => utility::post('telegram_id'),
			'full_time'   => utility::post('full_time'),
			'remote'      => utility::post('remote'),
			'is_default'  => utility::post('is_default'),
			'date_enter'  => utility::post('date_enter'),
			'date_exit'   => utility::post('date_exit'),
			'status'      => utility::post('status'),
		];
		return $args;
	}


	/**
	 * Gets the addmember.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_add($_args)
	{
		$request         = [];
		$this->user_id   = $this->login('id');
		$request['team'] = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		utility::set_request_array($request);
		$result = $this->get_team();
		return $result;

	}


	/**
	 * Posts an addmember.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_add($_args)
	{

		$request         = $this->getPost();
		$this->user_id   = $this->login('id');
		$request['team'] = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		utility::set_request_array($request);
		$this->add_member();
	}



// OLD CODE ************************************************************************************






	/**
	 * Gets the list.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_listmember($_args)
	{
		$this->user_id = $this->login('id');
		$team = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		utility::set_request_array(['team' => $team]);
		$result =  $this->get_list_member();

		return $result;
	}


	/**
	 * Gets the memberdashboard.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_memberdashboard($_args)
	{
		$request            = [];
		$this->user_id      = $this->login('id');
		$request['team'] = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		$request['member']  = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		utility::set_request_array($request);
		$result = $this->get_member();
		return $result;
	}


	/**
	 * Gets the editmember.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_editmember($_args)
	{
		$request            = [];
		$this->user_id      = $this->login('id');
		$request['team'] = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		$request['member']  = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		utility::set_request_array($request);
		return $this->get_member();
	}





	/**
	 * Posts an add.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_editmember($_args)
	{
		$request          = $this->getPost();
		$this->user_id    = $this->login('id');
		$request['team'] = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		$request['member']  = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;

		utility::set_request_array($request);
		$this->add_member(['method' => 'patch']);
	}


	/**
	 * Gets the editmember team.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function get_editmember_team($_args)
	{
		$userteam_id = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		utility::set_request_array(['id' => $userteam_id]);
		$this->user_id = $this->login('id');
		$result = $this->userteam_get_details();
		// var_dump($result);
		return $result;

	}


	/**
	 * Gets the editmember team.
	 *
	 * @param      <type>  $_args  The arguments
	 */
	public function post_editmember_team($_args)
	{
		$this->user_id      = $this->login('id');
		$userteam_id     = isset($_args->match->url[0][2]) ? $_args->match->url[0][2] : null;
		$request            = $this->getPost();
		$request['id']      = $userteam_id;
		$request['team'] = isset($_args->match->url[0][1]) ? $_args->match->url[0][1] : null;
		utility::set_request_array($request);
		$result = $this->add_member(['method' => 'patch']);
		// var_dump($result);
		return $result;

	}
}
?>